## Purpose

The clinical-notes capability provides an optional module for the patient's clinical history: specialist notes and post-session instructions per appointment, longitudinal clinical history entries, clinical attachments (images, videos, documents) holding study results, and medical prescriptions. Both the specialist and the patient can consult that history, and clinical data is only available while the module is active and only to authorized parties.

## ADDED Requirements

### Requirement: Module Activation Gate

The clinical-notes capability SHALL only be available when the clinical-notes module is active.

#### Scenario: Notes hidden when disabled
- WHEN the clinical-notes module is disabled
- THEN note and prescription features and routes SHALL NOT be available

#### Scenario: Notes available when enabled
- WHEN the clinical-notes module is enabled
- THEN specialists SHALL be able to add notes and patients SHALL be able to consult them

#### Scenario: Clinical history hidden when disabled
- WHEN the clinical-notes module is disabled
- THEN clinical history entries and clinical attachments SHALL NOT be available

#### Scenario: Uploads rejected when disabled
- WHEN a user attempts to upload a clinical attachment while the clinical-notes module is disabled
- THEN the system SHALL reject the request

### Requirement: Therapist Notes and Instructions

The system SHALL allow specialists to add private notes and post-session instructions visible to the patient.

#### Scenario: Specialist adds session notes
- WHEN a specialist adds notes to an appointment
- THEN those notes/instructions SHALL be stored securely

#### Scenario: Patient views their instructions
- WHEN a patient views a completed appointment
- THEN they SHALL see notes and instructions left by their specialist

#### Scenario: Notes privacy enforcement
- WHEN a patient attempts to access another patient's notes
- THEN the system SHALL deny access

### Requirement: Clinical History Records

The system SHALL maintain a longitudinal clinical history per patient, in addition to per-appointment notes, where every entry records its type, content, author, and timestamp.

#### Scenario: Specialist records a history entry
- WHEN a specialist adds an entry to a patient's clinical history
- THEN it SHALL be stored with its type, content, author, and timestamp

#### Scenario: Entry linked to an appointment
- WHEN a history entry is created from an appointment
- THEN it SHALL be linked to that appointment and to the patient

#### Scenario: History listed chronologically
- WHEN a patient or a specialist opens the clinical history
- THEN entries SHALL be listed in chronological order showing type, author, and date

#### Scenario: Patient cannot author history entries
- WHEN a patient attempts to create a clinical history entry
- THEN the system SHALL deny the request

### Requirement: Shared Access to Clinical History

The system SHALL let the patient and the specialists responsible for their care consult the same clinical history, each according to their access level.

#### Scenario: Patient consults own history
- WHEN a patient opens their clinical history
- THEN they SHALL see the entries shared with them

#### Scenario: Specialist consults assigned patient history
- WHEN a specialist opens the clinical history of a patient they are assigned to
- THEN they SHALL see all entries, including the internal ones

#### Scenario: Administrator consults history
- WHEN an administrator opens a patient's clinical history
- THEN they SHALL have full access to it

#### Scenario: Access to another patient's history denied
- WHEN a user requests the clinical history of a patient they are not authorized for
- THEN the system SHALL return not found or forbidden

### Requirement: History Entry Visibility

The system SHALL distinguish clinical history entries shared with the patient from internal entries intended only for the care team.

#### Scenario: Shared entry visible to patient
- WHEN a specialist marks a history entry as shared with the patient
- THEN the patient SHALL see it in their clinical history

#### Scenario: Internal entry hidden from patient
- WHEN a patient opens their clinical history
- THEN internal entries SHALL NOT be shown

#### Scenario: Attachments inherit entry visibility
- WHEN an attachment belongs to an internal entry
- THEN the patient SHALL NOT be able to open or download it

#### Scenario: Visibility change is audited
- WHEN a specialist changes the visibility of a history entry
- THEN the system SHALL record who changed it and when

### Requirement: Clinical Attachments

The system SHALL allow images, videos, and documents to be attached to clinical history entries, so that study results and other clinical media are stored with the patient's history.

#### Scenario: Specialist attaches study results
- WHEN a specialist attaches an image, video, or document to a history entry
- THEN the file SHALL be stored and associated with that entry

#### Scenario: Patient uploads own document
- WHEN a patient uploads a document or image to their history
- THEN it SHALL be stored as a patient-provided entry visible to the specialist

#### Scenario: Unsupported file type rejected
- WHEN a file whose type is not an accepted image, video, or document is uploaded
- THEN the system SHALL reject the upload

#### Scenario: Oversized file rejected
- WHEN an uploaded file exceeds 50 MB for images and documents or 250 MB for videos
- THEN the system SHALL reject the upload with a validation error

#### Scenario: Attachment metadata retained
- WHEN an attachment is stored
- THEN the system SHALL retain its original name, media type, and size

#### Scenario: Entry with attachments only
- WHEN an entry is created with attachments and no written content
- THEN it SHALL be stored and listed in the clinical history

### Requirement: Clinical File Protection

The system SHALL store clinical attachments on a private disk and serve them only to authorized users through time-limited links.

#### Scenario: No public file access
- WHEN a clinical attachment is stored
- THEN it SHALL NOT be reachable through a public or static URL

#### Scenario: Temporary download link issued
- WHEN an authorized user requests a clinical attachment
- THEN the system SHALL issue a time-limited authorized URL for it

#### Scenario: Unauthorized download denied
- WHEN a user without authorization requests a clinical attachment or its link
- THEN the system SHALL deny access

#### Scenario: Expired link rejected
- WHEN a link for a clinical attachment has expired
- THEN the system SHALL deny access and the user SHALL be able to request a new one

### Requirement: Unified Clinical Timeline

The system SHALL present notes, clinical history entries, attachments, and prescriptions as a single timeline per patient.

#### Scenario: Timeline aggregates clinical data
- WHEN a patient or a specialist opens the clinical history
- THEN notes, history entries, and prescriptions SHALL appear in a single chronological timeline

#### Scenario: Timeline filterable
- WHEN the clinical timeline is displayed
- THEN the viewer SHALL be able to filter it by entry type and date range

#### Scenario: Timeline respects visibility
- WHEN the clinical timeline is displayed for a patient
- THEN internal entries SHALL NOT appear

### Requirement: Immutable Clinical Record

The system SHALL preserve the integrity of clinical history entries and prescriptions by keeping their authorship and by withdrawing, rather than deleting, records that must be removed.

#### Scenario: Record not hard deleted
- WHEN a specialist attempts to delete a clinical history entry or a prescription
- THEN it SHALL be marked as void with a reason and remain auditable

#### Scenario: Authorship visible
- WHEN a clinical record is viewed
- THEN its author, creation date, and void state SHALL be displayed

#### Scenario: Prescription appears in the timeline
- WHEN a prescription is issued
- THEN it SHALL appear in the clinical timeline of the patient

### Requirement: Medical Prescriptions

The system SHALL allow specialists to issue medical prescriptions associated with a patient and appointment.

#### Scenario: Specialist issues a prescription
- WHEN a specialist creates a prescription for a patient
- THEN it SHALL be stored and associated with the patient and appointment

#### Scenario: Patient consults their prescriptions
- WHEN a patient views their prescriptions
- THEN they SHALL see only prescriptions issued to them

### Requirement: Prescriptions Gated by Module State

The system SHALL make prescriptions consultable only while the clinical-notes module is active.

#### Scenario: Prescriptions visible when active
- WHEN the clinical-notes module is active and a patient has prescriptions
- THEN the patient SHALL be able to consult them

#### Scenario: Prescriptions hidden when inactive
- WHEN the clinical-notes module is inactive
- THEN prescription consultation SHALL NOT be available to patients

### Requirement: Access Authorization for Clinical Data

The system SHALL restrict clinical notes and prescriptions to authorized users.

#### Scenario: Specialist access limited to assigned patients
- WHEN a specialist accesses clinical data
- THEN they SHALL only access data for their assigned patients

#### Scenario: Unauthorized access denied
- WHEN any user without authorization attempts to access clinical data
- THEN the system SHALL return not found or forbidden
