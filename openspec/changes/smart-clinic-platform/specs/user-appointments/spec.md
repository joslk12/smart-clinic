## Purpose

The user-appointments capability gives registered patients a private area to view and manage their own appointments. It also lets anonymous patients request a change or cancellation of an existing appointment through a unique, validated link without creating an account.

## ADDED Requirements

### Requirement: Registered Patient Appointment Management

The system SHALL provide authenticated patients with a private area to view and manage their own appointments.

#### Scenario: View upcoming appointments
- WHEN a registered patient views their appointments
- THEN they SHALL see their upcoming appointments with status and details

#### Scenario: View appointment history
- WHEN a registered patient views their history
- THEN they SHALL see their past appointments in chronological order

#### Scenario: Reschedule own appointment
- WHEN a registered patient requests a new time for their appointment
- THEN the appointment SHALL be updated or set to pending per policy

#### Scenario: Cancel own appointment
- WHEN a registered patient cancels their appointment within policy
- THEN the appointment status SHALL change to cancelled

### Requirement: Data Isolation

The system SHALL enforce that patients can only access their own appointments.

#### Scenario: Patient sees only own appointments
- WHEN a patient queries their appointments
- THEN results SHALL only include their own appointments

#### Scenario: Access to another patient's appointment denied
- WHEN any user attempts to access another patient's appointment
- THEN the system SHALL return not found or forbidden

### Requirement: Anonymous Appointment Access via Unique Link

The system SHALL issue a unique, secure code or link when an anonymous appointment is booked, allowing the patient to access and manage that appointment without an account.

#### Scenario: Issue access link on booking
- WHEN an anonymous appointment is created
- THEN the system SHALL generate a unique code/link and send it to the provided contact email

#### Scenario: Access appointment with valid link
- WHEN an anonymous patient opens a valid link
- THEN they SHALL be able to view that appointment's details

#### Scenario: Reject invalid or expired link
- WHEN a patient opens an invalid or expired link
- THEN the system SHALL deny access with an informative message

### Requirement: Anonymous Change or Cancellation Request

The system SHALL allow an anonymous patient, authenticated by a valid unique link, to request a change or cancellation of their appointment.

#### Scenario: Request reschedule as anonymous
- WHEN an anonymous patient submits a reschedule request via a valid link
- THEN the request SHALL be recorded and the appointment marked pending per policy

#### Scenario: Request cancellation as anonymous
- WHEN an anonymous patient submits a cancellation via a valid link
- THEN the appointment status SHALL change to cancelled per policy

#### Scenario: Validate identity before change
- WHEN an anonymous patient submits a change or cancellation
- THEN the system SHALL validate the unique code/link before applying it

### Requirement: User Appointments Always Active

The user-appointments capability SHALL be active by default and cannot be disabled.

#### Scenario: Appointment self-management available unconditionally
- WHEN a registered patient or valid anonymous link holder accesses their appointments
- THEN the capability SHALL be available regardless of module configuration
