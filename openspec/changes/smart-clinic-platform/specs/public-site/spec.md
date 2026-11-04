## Purpose

The public-site capability provides the public-facing website for the specialist practice (home and contact). It presents the practice identity, services overview, and location details with an embedded map so visitors can learn about the specialist and get in touch.

## ADDED Requirements

### Requirement: Public Home Page

The system SHALL provide a public home page at the root URL presenting the practice identity and its services for any specialist type.

#### Scenario: View home page
- WHEN an anonymous visitor accesses the root URL
- THEN they SHALL see the practice home page with branding, specialist type, and key information

#### Scenario: Home page includes service overview
- WHEN viewing the home page
- THEN it SHALL display an overview of offered services and a call-to-action to book an appointment

#### Scenario: Configure practice identity
- WHEN an administrator sets practice name, description, and specialist type
- THEN the home page SHALL reflect those settings

### Requirement: Contact Page with Location

The system SHALL provide a public contact page with contact information and an embedded location map.

#### Scenario: View contact page
- WHEN a visitor accesses the contact page
- THEN they SHALL see address, phone, email, and business hours

#### Scenario: Display location map
- WHEN viewing the contact page
- THEN an embedded map SHALL display the practice location

### Requirement: Public Navigation

The public site SHALL include navigation reflecting only the currently active modules.

#### Scenario: Navigate active public pages
- WHEN a visitor uses the site navigation
- THEN they SHALL be able to reach home, contact, and the active public modules (blog, shop, booking)

#### Scenario: Hidden modules not shown
- WHEN a module is disabled
- THEN its navigation entry SHALL NOT appear in the public site

### Requirement: Public Site Always Active

The public-site capability SHALL be active by default and cannot be disabled.

#### Scenario: Public site accessible unconditionally
- WHEN any visitor accesses the root URL
- THEN the public home page SHALL always be available regardless of module configuration
