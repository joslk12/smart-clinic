# Design

## Context

See proposal.md - Why. This is a greenfield Laravel + Vue 3 SPA for a generic specialist platform (therapist, psychologist, doctor, etc.), replacing an earlier hypnotherapy-specific proposal. The defining constraint is a configurable, module-based architecture: some capabilities are core and always on; others are optional and toggled at runtime.

## Goals / Non-Goals

**Goals:**
- Generic data model driven by configurable specialist type and services, not tied to any single specialty
- Hybrid module configuration (file defaults + database overrides) resolvable at runtime
- Real-time, one-to-one support messaging when enabled
- Anonymous appointment self-management via secure unique tokens
- Secure role-based access and patient data isolation
- Shared clinical history: the specialist and the patient consult the same longitudinal history, including clinical media (study results)
- Clean separation of Laravel API backend and Vue 3 SPA frontend

**Non-Goals:**
- Multi-tenant SaaS (single practice per installation, though the model should not preclude it later)
- Native mobile apps (web-first SPA)
- Full payment-gateway integration beyond a pluggable structure
- Advanced analytics/reporting
- Third-party calendar sync
- Collaborative/real-time editing of clinical records (append-only history with voiding instead)

## Decisions

### 1. Architecture: Laravel API + Vue 3 SPA
**Rationale:** Robust backend (auth, validation, Eloquent, queues, mail, broadcasting) with a modern reactive SPA (Composition API, Pinia, TypeScript). API-first enables future clients.
**Alternatives:** Inertia monolith (less flexible for real-time and future clients), Livewire (weaker SPA UX for chat/scheduling).

### 2. Module Configuration: Hybrid (file + DB)
**Rationale:** A `config/modules.php` file declares every module with `core` flag, default enabled state, and optional `requires` dependencies. A `settings`/`module_states` table stores admin overrides. A `ModuleRegistry` service resolves the effective state (DB override > file default), exposes it to API middleware and to the frontend via a bootstrap/settings endpoint.
**Alternatives:** File-only (requires redeploy to change; rejected), DB-only (no safe defaults before install).

**Enforcement:** A `EnsureModuleEnabled` middleware guards module routes; the SPA fetches module state and renders navigation/guards accordingly.

### 3. Generic Specialist Model
**Rationale:** `specialist_type` and `services` (name, duration, price) are data, not code. Users with the specialist role map to availability and services. This keeps booking generic across specialties.
**Alternatives:** Hard-coded specialty logic (rejected - not reusable).

### 4. Anonymous Appointment Access via Signed Tokens
**Rationale:** On anonymous booking, generate a unique, high-entropy token (signed/expiring) emailed to the patient. The link grants scoped, read/limited-write access to that one appointment for viewing, reschedule, or cancellation. Validation is token-based (Laravel signed URLs or an opaque token with expiry).
**Alternatives:** Lightweight guest accounts (heavier, more friction), email+data validation only (weaker security).

### 5. Real-Time Messaging
**Rationale:** Laravel broadcasting over WebSockets (Laravel Reverb, self-hosted) with private channels scoped to a conversation's participants. Messages persisted; read status tracked. One-to-one only.
**Alternatives:** Polling (simpler but not real time), Pusher (managed but external dependency/cost).

### 6. Authorization: Spatie Laravel Permission + Policies
**Rationale:** Roles (admin, specialist, patient) via Spatie; per-resource Policies enforce ownership (patient data isolation, assigned-patient access for specialists).

### 7. Authentication: Sanctum + Socialite
**Rationale:** Sanctum for SPA session/token auth; Socialite for Google OAuth. New Google users default to the patient role.

### 8. Data Model (key entities)
users (+roles), specialist_profiles, services, availabilities/blocked_slots, appointments (user_id nullable; contact fields + access token for anonymous), appointment_change_requests, conversations + messages, clinical_notes, clinical_entries (longitudinal history: type, content, visibility, author, patient, optional appointment), clinical_attachments (entry_id, disk, path, original name, mime type, size, uploader), prescriptions, posts + categories, products/orders/order_items, notifications, module_states.

### 9. File Storage & Notifications
Laravel filesystem (public disk, S3-capable) for media; Notifications (mail + database channels) queued for reliability.

### 10. Frontend Module Awareness
A settings/bootstrap endpoint returns active modules; Pinia stores it; router guards and navigation render from it, so disabled modules vanish from UI and API.

### 11. Clinical History and Clinical Media Storage
**Rationale:** The clinical-notes module doubles as the patient's clinical history: longitudinal entries (`clinical_entries`) authored by specialists, each with a visibility flag (shared with the patient / internal), plus attachments (`clinical_attachments`) holding study results as images, videos, or documents. Attachments live on a private disk and are served only through short-lived signed URLs after an authorization check, since a leaked static URL would expose health data. Patients read their own shared history and may upload their own documents (as patient-provided entries) but never author clinical entries. Clinical records are never hard-deleted: they are voided with a reason and remain auditable.
**Alternatives:** Public disk for clinical media (simpler, rejected - unacceptable exposure of health data); single free-text "medical history" field (rejected - no timeline, no attachments, no auditability); letting patients author clinical entries (rejected - blurs clinical authorship and legal responsibility).

## Risks / Trade-offs

- **[Risk]** Module state drift between backend and frontend → **Mitigation:** single source resolved by ModuleRegistry, delivered via bootstrap endpoint; API middleware as source of truth.
- **[Risk]** Real-time infra complexity/ops (Reverb) → **Mitigation:** optional module; abstract broadcasting so it can be disabled or swapped.
- **[Risk]** Anonymous token leakage/replay → **Mitigation:** high-entropy tokens, expiry, scope to a single appointment, rate limiting, no PII beyond that appointment.
- **[Risk]** Scheduling races (double-booking) → **Mitigation:** DB transactions + row locks + unique constraints on slot.
- **[Risk]** Clinical data privacy (notes, prescriptions) → **Mitigation:** strict Policies, specialist assignment checks, module gating, audit considerations.
- **[Risk]** Prescription consult leaking when module toggled → **Mitigation:** enforce gate at both API middleware and UI; prescriptions never cached client-side.
- **[Risk]** Clinical media exposure (images/videos/study results) → **Mitigation:** private disk, no static URLs, short-lived signed links issued only after authorization checks, strict per-file size limits, and the same module gate applied to uploads and downloads.
- **[Risk]** Clinical record tampering or silent deletion → **Mitigation:** append-only entries with author/timestamp, void-with-reason instead of hard delete, and audit of visibility changes.
- **[Risk]** Inventory oversell → **Mitigation:** transactional decrement with availability check at checkout.

## Migration Plan

1. Initialize Laravel API + Vue 3 SPA scaffolding; configure CORS.
2. Install Sanctum, Spatie Permission, Socialite, broadcasting (Reverb).
3. Build the module system first (config file, module_states, ModuleRegistry, middleware, bootstrap endpoint) so later modules plug in cleanly.
4. Migrate core entities (users/roles, specialist/services, appointments, access tokens) and seed roles/admin.
5. Implement core capabilities (public-site, auth-roles, scheduling, user-appointments, appointments-notifications).
6. Implement optional modules behind their gates (module-config UI, messaging, clinical-notes incl. clinical history and media attachments, blog, ecommerce).
7. Test per spec scenarios; configure queues/mail/broadcasting for production.

Rollback: each optional module is feature-gated, so disabling a module (config/DB) is the primary rollback for that feature.

## Open Questions

- Payment provider for ecommerce (integration deferred; structure must remain pluggable).
- Whether prescriptions need regulatory formatting per jurisdiction (deferrable; keep content generic).
