## Purpose

The messaging capability provides an optional real-time, one-to-one support chat between a patient and the specialist/support. It lets users ask questions and, when they booked anonymously, request appointment changes through a direct conversation channel.

## ADDED Requirements

### Requirement: Module Activation Gate

The messaging capability SHALL only be available when the messaging module is active.

#### Scenario: Messaging hidden when disabled
- WHEN the messaging module is disabled
- THEN messaging entry points and routes SHALL NOT be available

#### Scenario: Messaging available when enabled
- WHEN the messaging module is enabled
- THEN authenticated users SHALL be able to start and use conversations

### Requirement: One-to-One Conversations

The system SHALL support one-to-one conversations between a patient and the specialist/support.

#### Scenario: Start a conversation
- WHEN a patient starts a conversation
- THEN a one-to-one conversation thread SHALL be created with the specialist/support

#### Scenario: Conversation isolation
- WHEN a patient views their conversations
- THEN they SHALL only see conversations they participate in

### Requirement: Real-Time Message Delivery

The system SHALL deliver messages in real time between conversation participants.

#### Scenario: Message appears without reload
- WHEN a participant sends a message
- THEN the other participant SHALL receive it in real time without reloading the page

#### Scenario: Message ordering and persistence
- WHEN messages are exchanged
- THEN they SHALL be persisted and displayed in chronological order

### Requirement: Message Read Status

The system SHALL track and expose read status of messages.

#### Scenario: Mark messages as read
- WHEN a participant opens a conversation
- THEN unread messages SHALL be marked as read

#### Scenario: Unread indicator
- WHEN a participant has unread messages
- THEN an unread indicator SHALL be shown

### Requirement: Anonymous Appointment Change Requests via Chat

When messaging is active, the system SHALL allow a user authenticated by an anonymous appointment link to request a change through the conversation channel.

#### Scenario: Anonymous user requests change in chat
- WHEN an anonymous user authenticated by a valid link opens the support chat
- THEN they SHALL be able to send a change or cancellation request

#### Scenario: Link validation still required
- WHEN an anonymous user uses chat to request a change
- THEN the unique appointment link SHALL still be validated

### Requirement: Support Notification of New Messages

The system SHALL notify support/specialists of new incoming messages.

#### Scenario: Notify support of new message
- WHEN a patient sends a message and support is not viewing the conversation
- THEN support SHALL receive a notification
