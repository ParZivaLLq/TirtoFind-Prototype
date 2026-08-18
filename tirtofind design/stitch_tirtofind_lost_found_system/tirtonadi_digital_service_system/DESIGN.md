---
name: Tirtonadi Digital Service System
colors:
  surface: '#fbf9f8'
  surface-dim: '#dbdad9'
  surface-bright: '#fbf9f8'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f5f3f2'
  surface-container: '#efeded'
  surface-container-high: '#e9e8e7'
  surface-container-highest: '#e4e2e1'
  on-surface: '#1b1c1c'
  on-surface-variant: '#434655'
  inverse-surface: '#303030'
  inverse-on-surface: '#f2f0f0'
  outline: '#737686'
  outline-variant: '#c3c6d7'
  surface-tint: '#0053db'
  primary: '#004ac6'
  on-primary: '#ffffff'
  primary-container: '#2563eb'
  on-primary-container: '#eeefff'
  inverse-primary: '#b4c5ff'
  secondary: '#5e5e5e'
  on-secondary: '#ffffff'
  secondary-container: '#e0dfde'
  on-secondary-container: '#626362'
  tertiary: '#005796'
  on-tertiary: '#ffffff'
  tertiary-container: '#1d70b8'
  on-tertiary-container: '#e9f1ff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dbe1ff'
  primary-fixed-dim: '#b4c5ff'
  on-primary-fixed: '#00174b'
  on-primary-fixed-variant: '#003ea8'
  secondary-fixed: '#e3e2e1'
  secondary-fixed-dim: '#c7c6c5'
  on-secondary-fixed: '#1a1c1c'
  on-secondary-fixed-variant: '#464746'
  tertiary-fixed: '#d2e4ff'
  tertiary-fixed-dim: '#a0caff'
  on-tertiary-fixed: '#001c37'
  on-tertiary-fixed-variant: '#00497e'
  background: '#fbf9f8'
  on-background: '#1b1c1c'
  surface-variant: '#e4e2e1'
  status-found: '#00703C'
  status-pending: '#F59E0B'
  status-danger: '#D33222'
  surface-white: '#FFFFFF'
  border-subtle: '#E5E7EB'
typography:
  display-lg:
    fontFamily: Inter
    fontSize: 48px
    fontWeight: '700'
    lineHeight: 56px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Inter
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
    letterSpacing: -0.01em
  headline-lg-mobile:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
  headline-md:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  title-lg:
    fontFamily: Inter
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  label-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '500'
    lineHeight: 20px
  label-sm:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '600'
    lineHeight: 16px
    letterSpacing: 0.05em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 4px
  xs: 4px
  sm: 8px
  md: 16px
  lg: 24px
  xl: 32px
  gutter: 24px
  margin-mobile: 16px
  margin-desktop: 64px
  max-width: 1280px
---

## Brand & Style

The design system is engineered for the Lost & Found Management System of Terminal Tirtonadi, operating under the Ministry of Transportation. The brand personality is **authoritative, dependable, and highly efficient**. It balances the institutional trust of a government entity with the modern, frictionless experience of a high-end productivity tool.

The visual style is a hybrid of **Modern Corporate and Functional Minimalism**. It utilizes the structured clarity of GOV.UK (high legibility, clear information hierarchy) and infuses it with the sophisticated execution of Linear (subtle borders, precise spacing, and refined elevation). The interface must feel accessible to the general public while providing a powerful "command center" feel for terminal staff.

Key characteristics:
- **Clarity over Decoration:** Every element serves a functional purpose.
- **Institutional Trust:** Use of a strong corporate blue to signify government authority.
- **Precision:** Tight alignment and consistent geometry to reflect organized logistics.

## Colors

The palette is anchored by **Corporate Blue (#2563EB)**, providing a recognizable "official" feel. We utilize a high-contrast foundation where white and near-white surfaces ensure maximum readability.

- **Primary:** Used for primary actions, active navigation states, and key brand touchpoints.
- **Secondary/Neutral:** A range of cool grays (`#F3F2F1`) is used for page backgrounds and container fills to reduce visual fatigue.
- **Semantic Colors:** Statuses are strictly color-coded:
    - **Success (Green):** Items that are successfully 'Claimed' or 'Resolved'.
    - **Warning (Orange):** 'Pending' verification or 'In-Review' items.
    - **Danger (Red):** 'Expired' listings or 'Urgent' alerts.
- **Contrast:** Maintain a minimum 4.5:1 contrast ratio for all functional text against its background to meet accessibility standards.

## Typography

This design system uses **Inter** exclusively to ensure a clean, systematic appearance across all platforms. The type scale is designed with generous line heights to improve readability for users in high-stress situations (e.g., searching for a lost item).

- **Headlines:** Bold and tight-tracked for impact and authority.
- **Body Text:** Standardized at 16px for optimal legibility, using a slightly increased line height (1.5x) for blocks of text.
- **Labels:** Use medium weights for form labels and uppercase for small metadata tags to provide clear visual distinction.
- **Accessibility:** Never use a font size smaller than 12px for functional information.

## Layout & Spacing

The layout follows a **Fixed-Fluid Hybrid** model. On desktop, content is constrained to a 1280px max-width container to prevent line lengths from becoming unreadable.

- **Grid:** A 12-column grid is used for desktop layouts, collapsing to 4 columns for mobile.
- **Spacing Rhythm:** Based on a 4px baseline grid. Components should primarily use `16px (md)` or `24px (lg)` padding to ensure a breathable, "open" feel.
- **Data Density:** While the overall UI is spacious, data tables and management lists should use `sm (8px)` or `md (16px)` vertical padding to allow for efficient scanning of multiple records.

## Elevation & Depth

Hierarchy is established through **Tonal Layering** and **Soft Precision Shadows**. 

- **Surface Levels:** 
  - **Level 0 (Background):** `#F3F2F1` – The base floor of the application.
  - **Level 1 (Cards/Containers):** `#FFFFFF` – Primary content areas, using a 1px border (`#E5E7EB`) to define boundaries.
  - **Level 2 (Interaction):** Floating elements like modals or dropdowns use a "Soft Ambient Shadow" (0px 4px 20px rgba(0, 0, 0, 0.05)).
- **Precision Outlines:** Elements like input fields and buttons utilize high-contrast borders rather than heavy shadows to maintain a "Linear-inspired" professional aesthetic.

## Shapes

The shape language is **Structured yet Approachable**. We use a **Rounded (8px base)** corner radius to soften the institutional feel without appearing overly casual.

- **Standard Components:** 8px (`rounded-md`) for buttons, inputs, and small widgets.
- **Container Cards:** 16px (`rounded-lg`) for main content cards to create a modern, "app-like" feel.
- **Status Badges:** 100px (`rounded-full`) to create a distinct "pill" shape for item statuses (Found, Claimed, etc.).

## Components

### Buttons
- **Primary:** Solid `#2563EB` with white text. High-contrast, 8px radius.
- **Secondary:** White background with a 1px `#E5E7EB` border. 
- **Destructive:** Solid `#D33222` for high-risk actions.

### Cards
Main containers for lost item entries. Must feature a `16px` corner radius, a subtle `1px` border, and a soft shadow. Images within cards should be top-aligned with matched corner radii.

### Status Badges
Used in tables and cards to indicate item state.
- **Found:** Green background (10% opacity) with dark green text.
- **Pending:** Orange background (10% opacity) with dark orange text.
- **Claimed:** Grey background (10% opacity) with dark grey text.

### Input Fields
Clean, 8px rounded corners with a `1px` border that thickens and turns Primary Blue on focus. Use Inter-Medium for labels placed directly above the field.

### Data Tables
Modern, borderless design between rows. Use alternating row stripes (`#F9FAFB`) for readability. The first column (typically Item ID or Name) should be semi-bold to anchor the eye.

### Search Bar
A prominent, high-level component with a 12px radius, featuring a subtle search icon and a "Cmd+K" style keyboard shortcut hint for staff efficiency.