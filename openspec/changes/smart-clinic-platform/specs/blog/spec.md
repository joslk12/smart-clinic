## Purpose

The blog capability provides an optional content management module for practice news and educational articles. It lets administrators/owners create, publish, and manage posts while visitors browse, search, and read published content.

## ADDED Requirements

### Requirement: Module Activation Gate

The blog capability SHALL only be available when the blog module is active.

#### Scenario: Blog hidden when disabled
- WHEN the blog module is disabled
- THEN public blog pages and admin blog routes SHALL NOT be available

#### Scenario: Blog available when enabled
- WHEN the blog module is enabled
- THEN posts SHALL be publicly viewable and manageable by admins

### Requirement: Blog Post Management

The system SHALL allow authorized administrators/owners to create, read, update, and delete blog posts.

#### Scenario: Create new blog post
- WHEN an admin creates a post with title, content, and metadata
- THEN the post SHALL be saved in the system

#### Scenario: Publish draft post
- WHEN an admin publishes a draft post
- THEN the post SHALL become publicly visible

#### Scenario: Edit published post
- WHEN an admin edits a published post
- THEN the changes SHALL be saved and reflected on the public view

### Requirement: Public Blog Access

The system SHALL allow unauthenticated visitors to browse and read published blog posts when the module is active.

#### Scenario: List published posts
- WHEN a visitor views the blog listing
- THEN they SHALL see only published posts ordered by publication date

#### Scenario: View single post
- WHEN a visitor opens a published post
- THEN they SHALL see full title, content, author, and publication date

#### Scenario: Draft posts not publicly visible
- WHEN a visitor attempts to access a draft post
- THEN access SHALL be denied or return not found

### Requirement: Post Metadata

Blog posts SHALL support metadata including title, slug, excerpt, featured image, author, categories, and publication status.

#### Scenario: Auto-generate slug
- WHEN an admin creates a post with a title
- THEN a URL-friendly slug SHALL be generated

#### Scenario: Set featured image
- WHEN an admin uploads a featured image
- THEN it SHALL be associated with the post and displayed appropriately

### Requirement: Categories and Organization

The system SHALL support categorizing blog posts to improve discoverability.

#### Scenario: Assign post to category
- WHEN an admin assigns a post to one or more categories
- THEN it SHALL be filterable by those categories

#### Scenario: Browse by category
- WHEN a visitor filters by category
- THEN they SHALL see only posts in that category

### Requirement: Publishing Controls

The system SHALL support immediate and scheduled publishing of blog posts.

#### Scenario: Schedule post for future
- WHEN an admin sets a future publication date
- THEN the post SHALL become visible only after that date/time

#### Scenario: Unpublish post
- WHEN an admin unpublishes a post
- THEN it SHALL no longer be publicly accessible
