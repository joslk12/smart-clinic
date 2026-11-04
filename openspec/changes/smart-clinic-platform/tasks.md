# Tasks

## 1. Project Setup & Infrastructure

- [ ] 1.1 Initialize Laravel API project and verify it boots (`php artisan --version`, server runs)
- [ ] 1.2 Install backend dependencies (Sanctum, Spatie Permission, Socialite, Reverb/broadcasting) and verify they autoload
- [ ] 1.3 Initialize Vue 3 + Vite + TypeScript SPA and verify `npm run dev` starts cleanly
- [ ] 1.4 Configure CORS, API base URL, and env between Laravel and the SPA; verify an API call from the SPA succeeds
- [ ] 1.5 Set up database, environment, and migrations structure; verify migrations run
- [ ] 1.6 Create base models, traits, and service providers; verify models load

## 2. Module Configuration System (build first)

- [ ] 2.1 Create `config/modules.php` declaring every module with core flag, default state, and dependencies. Verify: file lists all 10 capabilities with correct flags
- [ ] 2.2 Create `module_states` migration/model for persisted overrides. Verify: overrides can be written/read
- [ ] 2.3 Implement `ModuleRegistry` service resolving effective state (DB override > file default). Verify: unit tests cover precedence and dependency disabling
- [ ] 2.4 Implement `EnsureModuleEnabled` middleware and register it. Verify: requests to a disabled module route are denied per specs
- [ ] 2.5 Create bootstrap/settings API endpoint returning active modules. Verify: endpoint returns correct state
- [ ] 2.6 Add a Pinia store + router guards consuming module state. Verify: disabled modules are hidden from navigation and blocked in the SPA

## 3. Authentication & Authorization

- [ ] 3.1 Configure Sanctum and verify auth endpoints respond
- [ ] 3.2 Configure Spatie Permission with roles (admin, specialist, patient). Verify: roles assignable/retrievable
- [ ] 3.3 Create User model with role relationships and verify registration/login per auth-roles specs
- [ ] 3.4 Implement auth controllers (register, login, logout, profile). Verify: full auth flow works end-to-end
- [ ] 3.5 Implement role-based middleware and policies. Verify: route protection enforces roles per scenarios
- [ ] 3.6 Create seeders for admin user and base roles. Verify: seeders run
- [ ] 3.7 Implement Google OAuth via Socialite (new users default to patient). Verify: Google SSO works for new and existing users

## 4. Generic Specialist & Services

- [ ] 4.1 Create migrations/models for specialist_profiles and services. Verify: models and relations work
- [ ] 4.2 Implement admin config for specialist type and services (CRUD). Verify: services selectable when booking; specialist type reflected on public site
- [ ] 4.3 Expose public practice profile (name, description, specialist type). Verify: home page reflects saved settings

## 5. Public Site

- [ ] 5.1 Implement public home page with identity, services overview, and booking CTA. Verify: loads at root with correct content
- [ ] 5.2 Create contact page with address, phone, email, hours, and embedded map. Verify: contact info and map render
- [ ] 5.3 Build navigation that reflects only active modules. Verify: disabled module entries do not appear
- [ ] 5.4 Verify public site is accessible without authentication and cannot be disabled

## 6. Scheduling

- [ ] 6.1 Create migrations/models for availability and appointments. Verify: relations correct
- [ ] 6.2 Implement availability management (working hours, blocked slots). Verify: availability CRUD works per specs
- [ ] 6.3 Implement anonymous booking with validation and pending status. Verify: anonymous booking requires contact info and succeeds
- [ ] 6.4 Implement registered booking linked to the user account. Verify: authenticated booking links to patient
- [ ] 6.5 Implement status management (pending/confirmed/cancelled/completed/no-show). Verify: transitions work
- [ ] 6.6 Implement double-booking prevention with transactions/locks. Verify: concurrent bookings do not conflict
- [ ] 6.7 Create scheduling API endpoints and Form Requests. Verify: all scheduling scenarios pass
- [ ] 6.8 Build scheduling UI (booking form, availability, specialist calendar). Verify: booking flow works in the SPA

## 7. User Appointments & Anonymous Access

- [ ] 7.1 Implement registered patient appointment area (view upcoming/history, reschedule, cancel). Verify: patients manage own appointments
- [ ] 7.2 Enforce data isolation policies. Verify: access to another patient's appointment is denied
- [ ] 7.3 Generate unique expiring token/link on anonymous booking and email it. Verify: link delivered on booking
- [ ] 7.4 Implement token validation endpoint and anonymous appointment view. Verify: valid links access; invalid/expired denied
- [ ] 7.5 Implement anonymous change/cancellation requests via validated link. Verify: requests recorded and status updated per policy
- [ ] 7.6 Build UI for registered self-management and anonymous link pages. Verify: both flows work

## 8. Appointments Notifications

- [ ] 8.1 Set up Laravel Notifications (mail + database channels). Verify: notifications create and send
- [ ] 8.2 Create notification classes for confirmation, reminders, cancellations. Verify: triggered on correct events
- [ ] 8.3 Implement queued notifications for reliability. Verify: jobs queue and process
- [ ] 8.4 Deliver anonymous access link via notifications. Verify: link emailed on anonymous booking
- [ ] 8.5 Add notification preferences. Verify: opt-out respected
- [ ] 8.6 Implement in-app notification center. Verify: notifications display
- [ ] 8.7 Add retry/error handling and logging. Verify: failures logged

## 9. Module Config Admin UI

- [ ] 9.1 Build admin panel to list modules with state and toggle optional ones. Verify: toggling persists override
- [ ] 9.2 Prevent disabling core modules in UI and API. Verify: core disable is rejected
- [ ] 9.3 Reflect dependency rules in UI (dependents unavailable when dependency off). Verify: dependent modules report unavailable

## 10. Messaging (optional module)

- [ ] 10.1 Create migrations/models for conversations and messages. Verify: relations correct
- [ ] 10.2 Configure broadcasting (Reverb) with private channels per conversation. Verify: a test event broadcasts to the right channel
- [ ] 10.3 Implement one-to-one conversations with isolation and persistence. Verify: users only see their conversations
- [ ] 10.4 Implement real-time send/receive and read status. Verify: messages appear without reload; read state updates
- [ ] 10.5 Allow anonymous-link users to request changes via chat with link validation. Verify: change request sent and validated
- [ ] 10.6 Notify support of new messages. Verify: support receives notification
- [ ] 10.7 Gate all messaging routes/UI behind module state. Verify: messaging unavailable when disabled
- [ ] 10.8 Build messaging UI (conversation list, thread, unread indicators). Verify: chat works end-to-end

## 11. Clinical Notes, Clinical History & Prescriptions (optional module)

- [ ] 11.1 Create migrations/models for clinical_notes, clinical_entries, clinical_attachments, and prescriptions. Verify: relations correct (entry ↔ patient/author/appointment, attachment ↔ entry/uploader)
- [ ] 11.2 Implement specialist notes/instructions per appointment. Verify: notes saved with authorization
- [ ] 11.3 Implement clinical history entries (type, content, author, timestamp, visibility, optional appointment link). Verify: entries stored and listed chronologically
- [ ] 11.4 Implement per-entry visibility (shared with patient vs internal). Verify: internal entries hidden from patients, visibility changes audited
- [ ] 11.5 Implement patient access to their own shared clinical history. Verify: patient sees only shared entries of their own history
- [ ] 11.6 Implement specialist/admin access to assigned patients' history. Verify: unassigned access denied, admin has full access
- [ ] 11.7 Implement clinical attachments (images, videos, documents) with type/size validation (50 MB images and documents, 250 MB videos) and metadata retention. Verify: invalid type/oversized uploads rejected
- [ ] 11.8 Implement patient upload of own documents as patient-provided entries. Verify: upload stored and visible to the specialist; patient cannot author clinical entries
- [ ] 11.9 Store clinical attachments on a private disk and serve them via short-lived signed URLs after authorization. Verify: no public/static URL works; unauthorized and expired links denied
- [ ] 11.10 Implement unified clinical timeline (notes, entries, attachments, prescriptions) with filtering by type and date range. Verify: timeline renders chronologically and respects visibility
- [ ] 11.11 Implement void-with-reason instead of hard delete for clinical records, keeping author and timestamps visible. Verify: deleted record remains auditable and marked void
- [ ] 11.12 Implement prescription issuance per patient/appointment. Verify: prescriptions stored, linked, and visible in the timeline
- [ ] 11.13 Implement patient consultation of notes and prescriptions. Verify: patients see only their own data
- [ ] 11.14 Enforce history, attachments, and prescriptions consultable only when module active. Verify: hidden and uploads rejected when disabled
- [ ] 11.15 Enforce specialist assignment access controls. Verify: unassigned access denied
- [ ] 11.16 Gate all clinical-notes routes/UI behind module state. Verify: unavailable when disabled
- [ ] 11.17 Build clinical history UI for specialist and patient (timeline, entry form, attachments gallery with preview/download). Verify: both roles browse the shared history end-to-end

## 12. Blog (optional module)

- [ ] 12.1 Create migrations/models for posts, categories, and pivot. Verify: relations work
- [ ] 12.2 Implement blog CRUD with publish/draft/schedule for admins. Verify: publishing controls work
- [ ] 12.3 Auto-generate unique slugs. Verify: slugs created and unique
- [ ] 12.4 Implement public blog API (listing, single, category filter). Verify: drafts not public
- [ ] 12.5 Handle featured images/media uploads. Verify: images stored and served
- [ ] 12.6 Build blog UI (listing, detail, admin management). Verify: public access works
- [ ] 12.7 Gate all blog routes/UI behind module state. Verify: unavailable when disabled

## 13. Ecommerce (optional module)

- [ ] 13.1 Create migrations/models for products, orders, order_items. Verify: relations correct
- [ ] 13.2 Implement product CRUD with inventory tracking. Verify: stock reflected in availability
- [ ] 13.3 Implement shopping cart (add/update/remove). Verify: cart operations correct
- [ ] 13.4 Implement checkout for anonymous and authenticated users. Verify: both flows create orders
- [ ] 13.5 Implement inventory validation (prevent oversell, check at checkout). Verify: constraints enforced
- [ ] 13.6 Implement order management (admin status updates, customer history). Verify: status tracked
- [ ] 13.7 Build ecommerce UI (catalog, detail, cart, checkout). Verify: purchase flow works end-to-end
- [ ] 13.8 Gate all ecommerce routes/UI behind module state. Verify: unavailable when disabled

## 14. Testing, Polish & Integration

- [ ] 14.1 Write API feature tests for core flows (auth, scheduling, user-appointments, module gating). Verify: tests pass
- [ ] 14.2 Write unit tests for ModuleRegistry precedence/dependencies and core business rules. Verify: tests pass
- [ ] 14.3 Write feature tests for optional modules (messaging, clinical-notes, blog, ecommerce) including gate enforcement. Verify: tests pass
- [ ] 14.4 Verify every spec scenario manually against the implementation. Verify: each scenario behaves as specified
- [ ] 14.5 Configure queues, mail, broadcasting, and storage for production. Verify: services configured
- [ ] 14.6 Run linting/type checking (Pint, ESLint, TypeScript). Verify: no errors

## Workflow follow-up

- Archive the change after review requirements are satisfied, updating the main specs.
