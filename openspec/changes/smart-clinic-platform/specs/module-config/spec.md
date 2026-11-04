## Purpose

The module-config capability provides a hybrid configuration system to enable or disable optional platform modules. Defaults live in a configuration file and can be overridden and persisted in the database, so an administrator can toggle modules from the admin panel without redeploying.

## ADDED Requirements

### Requirement: Module Registry

The system SHALL maintain a registry of platform modules, each marked as core (always active) or optional.

#### Scenario: Core modules always active
- WHEN the system resolves module state
- THEN core modules (public-site, auth-roles, scheduling, user-appointments, appointments-notifications) SHALL be reported as active

#### Scenario: Optional modules list
- WHEN an administrator views available modules
- THEN optional modules (blog, messaging, clinical-notes, ecommerce) SHALL be listed with their current state

### Requirement: Hybrid Configuration Source

The system SHALL resolve module state from file defaults with optional database overrides taking precedence.

#### Scenario: Default from file
- WHEN no database override exists for a module
- THEN its state SHALL come from the configuration file defaults

#### Scenario: Database override precedence
- WHEN a database override exists for a module
- THEN the database value SHALL take precedence over the file default

### Requirement: Toggle Modules from Admin Panel

The system SHALL allow administrators to enable or disable optional modules from the admin panel, persisting the change.

#### Scenario: Enable a module
- WHEN an administrator enables an optional module
- THEN the override SHALL be persisted and the module SHALL become active

#### Scenario: Disable a module
- WHEN an administrator disables an optional module
- THEN its features and navigation SHALL be hidden from users

#### Scenario: Core modules cannot be disabled
- WHEN an administrator attempts to disable a core module
- THEN the system SHALL reject the action

### Requirement: Enforcement of Module State

The system SHALL enforce module state across API routes and frontend navigation.

#### Scenario: Disabled module routes blocked
- WHEN a request targets a route belonging to a disabled module
- THEN the system SHALL deny access

#### Scenario: Navigation reflects active modules
- WHEN the frontend renders navigation
- THEN only entries for active modules SHALL be shown

### Requirement: Inter-Module Dependency

The system SHALL support dependencies between modules, disabling dependents when a dependency is inactive.

#### Scenario: Dependent module requires its dependency
- WHEN a module depends on another module that is disabled
- THEN the dependent module SHALL be reported as unavailable
