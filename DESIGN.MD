---
name: Vitality Grocer
colors:
    surface: "#f8faf5"
    surface-dim: "#d8dbd6"
    surface-bright: "#f8faf5"
    surface-container-lowest: "#ffffff"
    surface-container-low: "#f2f4ef"
    surface-container: "#ecefea"
    surface-container-high: "#e7e9e4"
    surface-container-highest: "#e1e3de"
    on-surface: "#191c1a"
    on-surface-variant: "#424939"
    inverse-surface: "#2e312e"
    inverse-on-surface: "#eff1ec"
    outline: "#737a68"
    outline-variant: "#c2c9b5"
    surface-tint: "#3c6a00"
    primary: "#3c6a00"
    on-primary: "#ffffff"
    primary-container: "#7cb342"
    on-primary-container: "#234100"
    inverse-primary: "#9dd761"
    secondary: "#8f4e00"
    on-secondary: "#ffffff"
    secondary-container: "#ff8f06"
    on-secondary-container: "#623300"
    tertiary: "#4d6453"
    on-tertiary: "#ffffff"
    tertiary-container: "#92aa97"
    on-tertiary-container: "#293f30"
    error: "#ba1a1a"
    on-error: "#ffffff"
    error-container: "#ffdad6"
    on-error-container: "#93000a"
    primary-fixed: "#b8f47a"
    primary-fixed-dim: "#9dd761"
    on-primary-fixed: "#0e2000"
    on-primary-fixed-variant: "#2c5000"
    secondary-fixed: "#ffdcc2"
    secondary-fixed-dim: "#ffb77b"
    on-secondary-fixed: "#2e1500"
    on-secondary-fixed-variant: "#6d3a00"
    tertiary-fixed: "#d0e9d4"
    tertiary-fixed-dim: "#b4cdb8"
    on-tertiary-fixed: "#0b2013"
    on-tertiary-fixed-variant: "#364c3c"
    background: "#f8faf5"
    on-background: "#191c1a"
    surface-variant: "#e1e3de"
typography:
    display-lg:
        fontFamily: Inter
        fontSize: 48px
        fontWeight: "700"
        lineHeight: 56px
        letterSpacing: -0.02em
    display-lg-mobile:
        fontFamily: Inter
        fontSize: 32px
        fontWeight: "700"
        lineHeight: 40px
        letterSpacing: -0.01em
    headline-md:
        fontFamily: Inter
        fontSize: 24px
        fontWeight: "600"
        lineHeight: 32px
    headline-sm:
        fontFamily: Inter
        fontSize: 20px
        fontWeight: "600"
        lineHeight: 28px
    body-lg:
        fontFamily: Inter
        fontSize: 18px
        fontWeight: "400"
        lineHeight: 28px
    body-md:
        fontFamily: Inter
        fontSize: 16px
        fontWeight: "400"
        lineHeight: 24px
    label-md:
        fontFamily: Inter
        fontSize: 14px
        fontWeight: "600"
        lineHeight: 20px
        letterSpacing: 0.01em
    label-sm:
        fontFamily: Inter
        fontSize: 12px
        fontWeight: "500"
        lineHeight: 16px
rounded:
    sm: 0.25rem
    DEFAULT: 0.5rem
    md: 0.75rem
    lg: 1rem
    xl: 1.5rem
    full: 9999px
spacing:
    base: 8px
    container-max: 1280px
    gutter: 24px
    margin-desktop: 64px
    margin-mobile: 16px
---

## Brand & Style

The design system is centered on the concept of "Fresh Vitality." It targets health-conscious individuals and busy families looking for a seamless, trustworthy way to source premium groceries and wellness products.

The visual style is a blend of **Modern Minimalism** and **Tactile Softness**. It prioritizes high-quality food photography and clear information hierarchy. By utilizing generous white space and soft, rounded elements, the interface feels approachable and "organic" rather than corporate. The goal is to evoke a sense of garden-fresh quality and reliability with every interaction.

## Colors

The palette is derived directly from nature. The primary **Vibrant Green** (#7CB342) signifies freshness and health, used for primary actions and key highlights. The **Fresh Orange** (#FB8C00) serves as a secondary accent color, perfect for promotional call-outs, sales, and urgent notifications.

The **Dark Forest Green** (#1B3022) provides a grounded, premium foundation, used primarily for footer backgrounds, deep typography, and high-contrast containers. Neutral tones lean toward a warm "Off-White" rather than clinical grey to maintain a welcoming, wellness-focused atmosphere.

## Typography

The design system utilizes **Inter** for its exceptional legibility and modern, clean aesthetic. The hierarchy is strictly enforced to ensure users can scan product names and prices effortlessly.

Headlines use a tighter letter-spacing and heavier weights to convey confidence and brand authority. Body text maintains a generous line height to ensure readability in ingredient lists and product descriptions. Mobile overrides are implemented for display sizes to prevent text wrapping issues on smaller viewports.

## Layout & Spacing

The system follows a **12-column fluid grid** for desktop, constrained by a 1280px maximum container width to maintain optical comfort.

- **Desktop:** 12 columns, 24px gutters, and 64px side margins.
- **Tablet:** 8 columns, 20px gutters, and 32px side margins.
- **Mobile:** 4 columns, 16px gutters, and 16px side margins.

Spacing is based on an 8px base unit. Product grids should utilize a "Masonry-lite" or strict row-based alignment depending on image aspect ratios, though 1:1 square ratios are preferred for grocery items.

## Elevation & Depth

This design system uses a **Soft Tonal** approach to depth. Rather than heavy shadows, it relies on subtle shifts in background color and "ambient" shadows to lift elements.

1.  **Level 0 (Base):** Neutral background (#F5F7F2).
2.  **Level 1 (Cards/Surface):** Pure White (#FFFFFF) with a very soft, diffused shadow (0px 4px 20px rgba(27, 48, 34, 0.05)).
3.  **Level 2 (Navigation/Sticky):** White background with a subtle bottom border or a slightly more pronounced shadow (0px 8px 30px rgba(27, 48, 34, 0.08)) to indicate it sits above all content.
4.  **Level 3 (Modals/Popovers):** Higher contrast shadows to ensure focus, often accompanied by a light background blur (8px) on the layers beneath.

## Shapes

The shape language is friendly and approachable. We use a **Rounded** (Level 2) logic consistently across the system.

- **Standard Buttons & Inputs:** 0.5rem (8px) radius.
- **Product Cards & Banners:** 1rem (16px) radius to create a soft, modern framing for food imagery.
- **Promotional Chips & Badges:** 1.5rem (24px) or full pill-shape to differentiate them from actionable buttons.

## Components

### Buttons

Primary buttons use the Vibrant Green background with white text. Secondary buttons use a ghost style (Green outline) or a light green tint. All buttons feature a subtle scale-down effect on press to feel tactile.

### Product Cards

The centerpiece of the UI. Cards must have a 1:1 image ratio, a subtle shadow, and a large 16px corner radius. The price is highlighted in Dark Forest Green, while the "Add to Cart" button is a prominent primary green circular icon or pill button.

### Search Bar

The search bar is oversized and centered in the navigation. It features a soft 12px radius, a magnifying glass icon in Green, and a subtle "shadow-on-focus" state to signify its importance.

### Promotional Banners

Banners use the Fresh Orange or Vibrant Green backgrounds with high-quality, cut-out food photography. Text should be minimal, using the 'Display' typography scale for impact.

### Sticky Navigation

The top navigation remains fixed. It uses a pure white background with a thin #E0E0E0 bottom border. It contains the logo, search bar, and user account/cart icons with clear label-sm text beneath icons for accessibility.
