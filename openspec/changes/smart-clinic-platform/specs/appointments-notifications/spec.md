## Purpose

The appointments-notifications capability ensures timely communication about appointments and related events. It manages notifications via email and in-app channels to keep patients and specialists informed about confirmations, reminders, changes, cancellations, and anonymous access links.

## ADDED Requirements

### Requirement: Appointment Confirmation Notifications

The system SHALL send confirmation notifications when appointments are created or confirmed.

#### Scenario: Send confirmation on booking
- WHEN a new appointment is successfully created
- THEN a confirmation notification SHALL be sent to the relevant parties

#### Scenario: Confirmation includes details
- WHEN a confirmation is sent
- THEN it SHALL include appointment date, time, specialist, and location/contact info

### Requirement: Appointment Reminder Notifications

The system SHALL send appointment reminders to patients prior to scheduled appointments.

#### Scenario: Automated reminder before appointment
- WHEN an appointment is upcoming per the reminder schedule
- THEN a reminder notification SHALL be sent to the patient

#### Scenario: Configurable reminder timing
- WHEN reminder timing is configured
- THEN reminders SHALL be sent at the specified intervals (e.g., 24h, 2h before)

### Requirement: Status Change Notifications

The system SHALL notify relevant parties when an appointment status changes.

#### Scenario: Notify on cancellation
- WHEN an appointment is cancelled
- THEN affected parties SHALL receive a cancellation notification

#### Scenario: Notify on reschedule or change
- WHEN an appointment time or date changes
- THEN the patient SHALL be notified of the update

### Requirement: Anonymous Access Link Delivery

The system SHALL deliver the unique code/link for anonymous appointment management through notification channels.

#### Scenario: Send access link on anonymous booking
- WHEN an anonymous appointment is created
- THEN the unique management link SHALL be emailed to the provided contact address

### Requirement: Notification Channels

The system SHALL support multiple notification channels (email and in-app notifications).

#### Scenario: Email notification delivery
- WHEN a notification is triggered for the email channel
- THEN the email SHALL be queued and sent

#### Scenario: In-app notification display
- WHEN a notification is created for an authenticated user
- THEN it SHALL appear in their in-app notification center

### Requirement: Notification Preferences

The system SHALL respect user notification preferences where applicable.

#### Scenario: Respect opt-out settings
- WHEN a user has disabled a notification type
- THEN the system SHALL not send that notification type

#### Scenario: Default preferences
- WHEN a new user is created
- THEN sensible default notification preferences SHALL apply

### Requirement: Delivery Reliability

The system SHALL ensure notification delivery with appropriate error handling and logging.

#### Scenario: Failed delivery logging
- WHEN a notification delivery fails
- THEN the failure SHALL be logged for review

#### Scenario: Retry on transient failure
- WHEN an email delivery encounters a transient error
- THEN the system SHALL retry per configured policy

### Requirement: Notifications Always Active

The appointments-notifications capability SHALL be active by default and cannot be disabled.

#### Scenario: Appointment notifications available unconditionally
- WHEN any appointment event occurs
- THEN notifications SHALL be sent regardless of module configuration
