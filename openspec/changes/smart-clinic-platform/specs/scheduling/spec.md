## Purpose

The scheduling capability enables patients (anonymous and registered) to book appointments with a specialist. It provides administrators and specialists with tools to manage availability, confirm or cancel appointments, and track appointment status while preventing double-booking.

## ADDED Requirements

### Requirement: Availability Management

The system SHALL allow specialists and administrators to define and manage available time slots for appointments.

#### Scenario: Define working hours
- WHEN a specialist sets their working hours
- THEN those time slots SHALL be available for booking

#### Scenario: Block unavailable time
- WHEN a specialist blocks a specific time slot
- THEN it SHALL not be bookable by patients

### Requirement: Service Definition

The system SHALL allow the practice to define services (appointment types) with a name, duration, and optional price, adaptable to any specialist type.

#### Scenario: Create a service
- WHEN an administrator creates a service with name and duration
- THEN it SHALL be selectable when booking appointments

#### Scenario: Multiple specialist types supported
- WHEN the practice configures its specialist type or types
- THEN services and booking SHALL remain generic to any specialty

### Requirement: Anonymous Appointment Booking

The system SHALL allow unauthenticated users to request appointments by providing required contact information.

#### Scenario: Successful anonymous booking
- WHEN an anonymous user provides valid contact details and selects an available slot
- THEN the appointment request SHALL be created with pending status

#### Scenario: Anonymous booking requires contact info
- WHEN an anonymous user attempts to book without required contact details
- THEN the system SHALL reject the booking with validation errors

### Requirement: Registered User Booking

The system SHALL allow authenticated patients to book appointments linked to their user account.

#### Scenario: Authenticated patient books appointment
- WHEN an authenticated patient selects an available slot
- THEN the appointment SHALL be created and linked to their account

### Requirement: Appointment Status Management

The system SHALL track appointment status (pending, confirmed, cancelled, completed, no-show) with appropriate transitions.

#### Scenario: Confirm pending appointment
- WHEN a specialist or admin confirms a pending appointment
- THEN the status SHALL change to confirmed

#### Scenario: Cancel appointment
- WHEN an authorized user cancels an appointment within policy
- THEN the status SHALL change to cancelled with an audit trail

### Requirement: Prevent Double Booking

The system SHALL prevent multiple appointments from being booked for the same specialist at the same time slot.

#### Scenario: Attempt to double book
- WHEN a user tries to book an already booked slot
- THEN the system SHALL reject with an error indicating the slot is unavailable

#### Scenario: Race condition protection
- WHEN concurrent booking attempts occur for the same slot
- THEN only one booking SHALL succeed

### Requirement: Appointment Validation

The system SHALL validate appointment requests against business rules (future dates, working hours, duration).

#### Scenario: Booking in the past rejected
- WHEN a user attempts to book a past date/time
- THEN the system SHALL reject the request

#### Scenario: Booking outside working hours rejected
- WHEN a user attempts to book outside specialist availability
- THEN the system SHALL reject the request

### Requirement: Scheduling Always Active

The scheduling capability SHALL be active by default and cannot be disabled.

#### Scenario: Booking available unconditionally
- WHEN a visitor accesses the booking flow
- THEN scheduling SHALL always be available regardless of module configuration
