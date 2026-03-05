#!/usr/bin/env python3
"""Generate ADA/WCAG 2.1 AA Audit Report PDF."""

from fpdf import FPDF
from datetime import date


class AuditPDF(FPDF):
    def header(self):
        self.set_font("Helvetica", "B", 9)
        self.set_text_color(100, 100, 100)
        self.cell(0, 8, "CST Cannabis Portal - WCAG 2.1 AA Accessibility Audit", align="L")
        self.cell(0, 8, "February 20, 2026", align="R", new_x="LMARGIN", new_y="NEXT")
        self.set_draw_color(200, 200, 200)
        self.line(10, self.get_y(), 200, self.get_y())
        self.ln(4)

    def footer(self):
        self.set_y(-15)
        self.set_font("Helvetica", "I", 8)
        self.set_text_color(150, 150, 150)
        self.cell(0, 10, f"Page {self.page_no()}/{{nb}}", align="C")

    def section_title(self, title, r=31, g=46, b=84):
        self.set_font("Helvetica", "B", 14)
        self.set_text_color(r, g, b)
        self.ln(4)
        self.cell(0, 8, title, new_x="LMARGIN", new_y="NEXT")
        self.set_draw_color(127, 163, 91)
        self.set_line_width(0.8)
        self.line(10, self.get_y(), 80, self.get_y())
        self.set_line_width(0.2)
        self.ln(4)

    def subsection(self, title):
        self.set_font("Helvetica", "B", 11)
        self.set_text_color(50, 50, 50)
        self.multi_cell(0, 6, title, new_x="LMARGIN", new_y="NEXT")
        self.ln(1)

    def body_text(self, text):
        self.set_font("Helvetica", "", 10)
        self.set_text_color(60, 60, 60)
        self.multi_cell(0, 5, text, new_x="LMARGIN", new_y="NEXT")
        self.ln(2)

    def issue_block(self, number, title, severity_color, wcag_ref, description, fix):
        # Check if we need a new page (estimate ~40mm per issue block)
        if self.get_y() > 240:
            self.add_page()

        # Issue number + title
        self.set_font("Helvetica", "B", 10)
        self.set_text_color(*severity_color)
        self.cell(8, 6, f"{number}.", new_x="RIGHT")
        self.set_text_color(40, 40, 40)
        self.multi_cell(0, 6, title, new_x="LMARGIN", new_y="NEXT")

        # WCAG reference
        self.set_x(18)
        self.set_font("Helvetica", "I", 8)
        self.set_text_color(100, 100, 100)
        self.cell(0, 4, wcag_ref, new_x="LMARGIN", new_y="NEXT")
        self.ln(1)

        # Description
        self.set_x(18)
        self.set_font("Helvetica", "", 9)
        self.set_text_color(60, 60, 60)
        self.multi_cell(self.w - self.r_margin - 18, 4.5, description, new_x="LMARGIN", new_y="NEXT")
        self.ln(1)

        # Fix
        self.set_x(18)
        self.set_font("Helvetica", "B", 9)
        self.set_text_color(94, 124, 58)
        self.cell(8, 4.5, "Fix: ", new_x="RIGHT")
        self.set_font("Helvetica", "", 9)
        self.set_text_color(60, 60, 60)
        self.multi_cell(self.w - self.r_margin - 26, 4.5, fix, new_x="LMARGIN", new_y="NEXT")
        self.ln(4)

    def contrast_table(self, rows):
        self.set_font("Helvetica", "B", 8)
        self.set_fill_color(31, 46, 84)
        self.set_text_color(255, 255, 255)
        col_widths = [72, 22, 22, 16, 18, 18]
        headers = ["Element", "FG", "BG", "Ratio", "AA", "AA Lg"]
        for i, h in enumerate(headers):
            self.cell(col_widths[i], 6, h, border=1, fill=True, align="C")
        self.ln()

        self.set_font("Helvetica", "", 7.5)
        fill = False
        for row in rows:
            if self.get_y() > 265:
                self.add_page()
            self.set_fill_color(245, 245, 245) if fill else self.set_fill_color(255, 255, 255)
            for i, val in enumerate(row):
                if i >= 4:  # Status columns
                    if val == "FAIL":
                        self.set_text_color(200, 50, 50)
                    else:
                        self.set_text_color(46, 125, 50)
                else:
                    self.set_text_color(60, 60, 60)
                align = "C" if i >= 2 else "L"
                self.cell(col_widths[i], 5, val, border=1, fill=fill, align=align)
            self.ln()
            fill = not fill
        self.ln(4)


def main():
    pdf = AuditPDF()
    pdf.alias_nb_pages()
    pdf.set_auto_page_break(auto=True, margin=20)
    pdf.add_page()

    # Title
    pdf.set_font("Helvetica", "B", 22)
    pdf.set_text_color(31, 46, 84)
    pdf.cell(0, 12, "Accessibility Audit Report", align="C", new_x="LMARGIN", new_y="NEXT")
    pdf.set_font("Helvetica", "", 12)
    pdf.set_text_color(100, 100, 100)
    pdf.cell(0, 8, "WCAG 2.1 AA / ADA Compliance Assessment", align="C", new_x="LMARGIN", new_y="NEXT")
    pdf.ln(4)

    # Meta info
    pdf.set_font("Helvetica", "", 10)
    pdf.set_text_color(60, 60, 60)
    meta = [
        ("Site:", "CST Cannabis Medicinal y Seguridad Vial"),
        ("URL:", "https://cst.pr.gov (localhost:8888 dev)"),
        ("Theme:", "cst-cannabis-portal (GeneratePress child)"),
        ("Date:", "February 20, 2026"),
        ("Standard:", "WCAG 2.1 Level AA, ADA Title II, Ley 229-2003, Section 508"),
    ]
    for label, value in meta:
        pdf.set_font("Helvetica", "B", 10)
        pdf.cell(22, 5, label, new_x="RIGHT")
        pdf.set_font("Helvetica", "", 10)
        pdf.cell(0, 5, value, new_x="LMARGIN", new_y="NEXT")
    pdf.ln(4)

    # Executive Summary
    pdf.section_title("Executive Summary")
    pdf.body_text(
        "The site demonstrates a strong accessibility foundation with many positive patterns: "
        "proper lang attribute, skip links, ARIA landmarks, labeled form controls, screen-reader text, "
        "prefers-reduced-motion support, forced-colors support, and high-contrast mode overrides.\n\n"
        "However, there are critical color contrast failures, several landmark/role conflicts, "
        "touch target shortfalls, and ARIA misuse patterns that must be resolved to achieve "
        "full WCAG 2.1 AA compliance."
    )

    # Stats summary box
    pdf.set_fill_color(245, 247, 250)
    pdf.set_draw_color(200, 200, 200)
    y = pdf.get_y()
    pdf.rect(10, y, 190, 22, style="DF")
    pdf.set_xy(15, y + 3)
    pdf.set_font("Helvetica", "B", 10)
    pdf.set_text_color(31, 46, 84)
    pdf.cell(45, 6, "5 Critical Issues", new_x="RIGHT")
    pdf.set_text_color(200, 100, 0)
    pdf.cell(45, 6, "6 Major Issues", new_x="RIGHT")
    pdf.set_text_color(100, 100, 100)
    pdf.cell(45, 6, "5 Minor Issues", new_x="RIGHT")
    pdf.set_text_color(46, 125, 50)
    pdf.cell(45, 6, "24 Items Pass", new_x="LMARGIN", new_y="NEXT")
    pdf.set_xy(15, y + 11)
    pdf.set_font("Helvetica", "", 8)
    pdf.set_text_color(100, 100, 100)
    pdf.cell(0, 6, "Priority fixes focus on color contrast (affecting buttons, headings, badges) and duplicate ARIA landmarks.", new_x="LMARGIN", new_y="NEXT")
    pdf.ln(6)

    # ── CRITICAL ISSUES ──
    pdf.section_title("Critical Issues", 200, 50, 50)
    RED = (200, 50, 50)

    pdf.issue_block(
        1,
        "Color Contrast: White text on #7FA35B green - ratio 2.88:1 (needs 4.5:1)",
        RED, "WCAG SC 1.4.3 - Contrast (Minimum) - Level AA",
        "The primary brand green #7FA35B paired with white text fails both the 4.5:1 threshold "
        "for normal text and the 3:1 threshold for large text. Affects: primary buttons (.cst-btn--primary), "
        "skip link, language badge, back-to-top button, active filter tabs, and objective card icon hover state.",
        "Replace #7FA35B with #5E7C3A (ratio 4.75:1) in any background paired with white text. "
        "Update --cst-gradient-primary start color accordingly."
    )

    pdf.issue_block(
        2,
        "Gradient heading text: lightest point #7FA35B on white fails contrast",
        RED, "WCAG SC 1.4.3 - Contrast (Minimum) - Level AA",
        "Section heading titles use background: var(--cst-gradient-text) with -webkit-text-fill-color: transparent. "
        "The gradient runs from #7FA35B to #1F2E54. WCAG evaluates the least-contrasting point, which at #7FA35B "
        "yields only 2.88:1 against the white section background. Also affects .cst-tag text (#7FA35B on #F8F9FA = 2.73:1).",
        "Use solid #1F2E54 or #5E7C3A for heading text color. Apply gradient as a decorative "
        "border-bottom only. Change tag text color to #5E7C3A."
    )

    pdf.issue_block(
        3,
        "Duplicate role=\"banner\" landmarks",
        RED, "WCAG SC 1.3.6 - Identify Purpose / 4.1.2 - Name, Role, Value",
        "Two elements carry role=\"banner\": the custom institutional header (<div class=\"cst-institutional-header\" "
        "role=\"banner\">) and the GP .site-header (via JavaScript setAttribute). ARIA spec allows only one "
        "role=\"banner\" per page. Similarly, duplicate role=\"contentinfo\" exists on the footer.",
        "Remove the JS-added role=\"banner\" from the GP header script. The custom institutional "
        "header should be the sole banner landmark. Same for contentinfo on footer."
    )

    pdf.issue_block(
        4,
        "Duplicate skip links pointing to different targets",
        RED, "WCAG SC 2.4.1 - Bypass Blocks - Level A",
        "Two skip links exist: a custom one (#main-content, Spanish) and GeneratePress default "
        "(#content, English). The GP link is also in English on a Spanish-language site, creating "
        "redundancy and language inconsistency.",
        "Remove the GP default skip link via remove_action hook. Keep only the custom Spanish "
        "skip link targeting #main-content."
    )

    pdf.issue_block(
        5,
        "Stat card source text opacity drops contrast below threshold",
        RED, "WCAG SC 1.4.3 - Contrast (Minimum) - Level AA",
        "The .cst-stat-card__source applies opacity: 0.8 to #6C757D text on white, resulting in "
        "an effective color of approximately #899197 with a ratio of 3.20:1, failing the 4.5:1 "
        "requirement for normal body text.",
        "Remove opacity: 0.8 or use a darker solid color such as #495057 (ratio 8.18:1) without opacity."
    )

    # ── MAJOR ISSUES ──
    pdf.section_title("Major Issues", 200, 130, 0)
    ORANGE = (200, 130, 0)

    pdf.issue_block(
        6,
        "Chatbot dialog missing aria-modal and aria-labelledby",
        ORANGE, "WCAG SC 4.1.2 - Name, Role, Value - Level AA",
        "The chatbot window has role=\"dialog\" and aria-label=\"Ventana de chat\" but lacks aria-modal=\"true\" "
        "(focus not trapped) and uses a different name than the visible title \"Asistente Virtual\" "
        "(violates SC 2.5.3 Label in Name).",
        "Add aria-modal=\"true\", add id to the title span, and replace aria-label with aria-labelledby "
        "pointing to the visible title element."
    )

    pdf.issue_block(
        7,
        "Touch targets below 44x44px minimum",
        ORANGE, "WCAG SC 2.5.5 / 2.5.8 - Target Size",
        "Header search button: 40x40px. Social link icons: 40x40px. Submenu nav links: min-height 40px. "
        "All fall below the project's own 44px standard defined in accessibility.css.",
        "Update .cst-header-search__btn, .cst-social-links a, and submenu links to 44px minimum dimensions."
    )

    pdf.issue_block(
        8,
        "aria-live=\"polite\" on stat counters announces every intermediate value",
        ORANGE, "WCAG SC 4.1.3 - Status Messages - Level AA",
        "Four stat value containers have aria-live=\"polite\". The counter JS animates from 0 to target, "
        "causing screen readers to announce every intermediate number, which is extremely disruptive.",
        "Remove aria-live=\"polite\" from .cst-stat-card__value. Set final values in DOM immediately "
        "for AT, animate visually only. Use a single role=\"status\" summary after completion."
    )

    pdf.issue_block(
        9,
        "Footer headings skip from h2 to h4 (no h3)",
        ORANGE, "WCAG SC 1.3.1 - Info and Relationships - Level A",
        "Footer widget titles use <h4> but there is no <h3> in the heading hierarchy before them, "
        "creating a skipped heading level in the document outline.",
        "Change .cst-footer-widget__title elements from <h4> to <h2> as independent section headings "
        "within the footer landmark."
    )

    pdf.issue_block(
        10,
        "Two mobile menu toggle buttons with identical aria-controls",
        ORANGE, "WCAG SC 4.1.2 - Name, Role, Value - Level AA",
        "Two <button> elements have aria-controls=\"primary-menu\" and aria-expanded=\"false\". Both may be "
        "focusable simultaneously and aria-expanded state may not be synchronized.",
        "Ensure only one toggle button is in the accessibility tree at any breakpoint. Use aria-hidden=\"true\" "
        "on the inactive one, or remove the duplicate from the DOM."
    )

    pdf.issue_block(
        11,
        "<nav aria-label=\"Mobile Toggle\"> wraps only a button, not navigation links",
        ORANGE, "Best Practice - SC 1.3.6",
        "GP wraps the hamburger button in a <nav> element, creating a spurious navigation landmark. "
        "The label is also in English on a Spanish page.",
        "Replace the <nav> wrapper with a <div> using a GP filter hook. Translate the label to Spanish."
    )

    # ── MINOR ISSUES ──
    pdf.section_title("Minor Issues", 100, 100, 100)
    GRAY = (100, 100, 100)

    pdf.issue_block(
        12,
        ".cst-animate { opacity: 0 } hides content if JavaScript fails",
        GRAY, "WCAG SC 1.3.3 - Sensory Characteristics",
        "Elements with .cst-animate start at opacity: 0 and rely on JS to reveal them. "
        "If JS fails to load, content remains invisible.",
        "Apply .cst-animate class via JS only, or add a <noscript> block that overrides opacity to 1."
    )

    pdf.issue_block(
        13,
        "Search input :focus removes outline without :focus-visible guard",
        GRAY, "WCAG SC 2.4.7 - Focus Visible - Level AA",
        "The .cst-header-search__input:focus rule sets outline: none with only a faint box-shadow "
        "(0.15 opacity) as replacement. The border color change uses #7FA35B which has only 2.88:1 "
        "contrast for non-text focus indicators.",
        "Use outline: none only under :focus:not(:focus-visible). For :focus-visible, preserve the "
        "browser outline or use --cst-color-focus (#3B82C4, 4.06:1)."
    )

    pdf.issue_block(
        14,
        "Gov banner toggle color #3B82C4 on white - ratio 4.06:1",
        GRAY, "WCAG SC 1.4.3 - Contrast (Minimum) - Level AA",
        "The 'Asi es como usted puede verificarlo' toggle text at #3B82C4 on white just barely fails "
        "the 4.5:1 threshold for normal-sized text.",
        "Change color to --cst-color-green-dark (#5E7C3A, 4.75:1) or --cst-color-secondary (#1F2E54)."
    )

    pdf.issue_block(
        15,
        "Hidden GP site-branding still in DOM for screen readers",
        GRAY, "Best Practice - SC 1.3.1",
        "The GP <p class=\"main-title\"> inside .site-branding is hidden via CSS display: none, which "
        "removes it from the accessibility tree. This is acceptable but could be cleaner.",
        "Add aria-hidden=\"true\" to .site-branding or remove the markup entirely via GP hook."
    )

    pdf.issue_block(
        16,
        "OIG logo link has redundant accessible name",
        GRAY, "Best Practice - SC 1.1.1, 2.4.6",
        "The <a> has aria-label=\"Oficina del Inspector General\" AND the <img> has the same alt text, "
        "potentially causing double-reading in some screen readers.",
        "Remove aria-label from the <a> (let img alt provide the name) or set alt=\"\" on the image."
    )

    # ── COLOR CONTRAST TABLE ──
    pdf.add_page()
    pdf.section_title("Color Contrast Summary")

    contrast_rows = [
        ["White on #7FA35B (buttons, skip link)", "#FFF", "#7FA35B", "2.88:1", "FAIL", "FAIL"],
        ["Gradient text #7FA35B on white", "#7FA35B", "#FFF", "2.88:1", "FAIL", "FAIL"],
        ["Tag text #7FA35B on #F8F9FA", "#7FA35B", "#F8F9FA", "2.73:1", "FAIL", "FAIL"],
        ["Gov toggle #3B82C4 on white", "#3B82C4", "#FFF", "4.06:1", "FAIL", "PASS"],
        ["Stat source (gray + opacity)", "#899197", "#FFF", "3.20:1", "FAIL", "PASS"],
        ["Muted text #6C757D on #F8F9FA", "#6C757D", "#F8F9FA", "4.45:1", "FAIL", "PASS"],
        ["Dark green #5E7C3A on white", "#5E7C3A", "#FFF", "4.75:1", "PASS", "PASS"],
        ["Navy #1F2E54 on white", "#1F2E54", "#FFF", "13.3:1", "PASS", "PASS"],
        ["Gray-700 #495057 on white", "#495057", "#FFF", "8.18:1", "PASS", "PASS"],
        ["White on gov banner #212529", "#FFF", "#212529", "15.4:1", "PASS", "PASS"],
        ["White on navy #1F2E54 header", "#FFF", "#1F2E54", "13.3:1", "PASS", "PASS"],
        ["Focus outline #3B82C4 (3:1 req)", "#3B82C4", "#FFF", "4.06:1", "PASS", "PASS"],
        ["Footer links on #1a1a2e", "#DEE2E6", "#1a1a2e", "11.2:1", "PASS", "PASS"],
    ]
    pdf.contrast_table(contrast_rows)

    # ── PASSING ITEMS ──
    pdf.section_title("Items Passing Compliance", 46, 125, 50)

    passing_items = [
        "HTML lang=\"es\" attribute present (SC 3.1.1)",
        "Descriptive <title> element (SC 2.4.2)",
        "Viewport meta: initial-scale=1, no user-scalable=no (SC 1.4.4)",
        "All <img> tags have appropriate alt attributes (SC 1.1.1)",
        "Decorative SVGs have aria-hidden=\"true\"",
        "Form labels properly associated with inputs (SC 1.3.1, 4.1.2)",
        "Search form has role=\"search\" and aria-label (SC 1.3.1)",
        "Heading hierarchy h1 > h2 > h3 correct in main content (SC 1.3.1)",
        "aria-current=\"page\" on active menu item (SC 4.1.2)",
        "Skip-to-content link present and functional (SC 2.4.1)",
        "prefers-reduced-motion: all animations suppressed (SC 2.3.3)",
        "prefers-contrast: high mode fully supported",
        "forced-colors: active mode fully supported",
        "aria-expanded on toggle buttons (SC 4.1.2)",
        "aria-controls on gov banner toggle",
        "Social links have descriptive aria-labels (SC 2.4.6)",
        "External links have rel=\"noopener noreferrer\"",
        "Chatbot role=\"log\" with aria-live=\"polite\" (SC 4.1.3)",
        "44px touch targets on most interactive elements (SC 2.5.5)",
        "Proper .sr-only implementation for screen reader text",
        "Chatbot close button has aria-label=\"Cerrar chat\"",
        "Back-to-top button has aria-label=\"Volver al inicio\"",
        "::selection styling uses brand colors",
        "Visited link color #5E7C3A passes contrast (4.75:1)",
    ]

    pdf.set_font("Helvetica", "", 9)
    pdf.set_text_color(60, 60, 60)
    for item in passing_items:
        if pdf.get_y() > 270:
            pdf.add_page()
        pdf.set_text_color(46, 125, 50)
        pdf.cell(5, 5, "+", new_x="RIGHT")
        pdf.set_text_color(60, 60, 60)
        pdf.cell(0, 5, item, new_x="LMARGIN", new_y="NEXT")

    # ── PRIORITY FIX LIST ──
    pdf.ln(6)
    pdf.section_title("Prioritized Fix List")

    pdf.subsection("Priority 1 - Fix First (Critical WCAG Failures)")
    p1 = [
        "Replace white-on-#7FA35B with white-on-#5E7C3A throughout (buttons, skip link, badges)",
        "Fix section heading gradient text to use solid #1F2E54 or #5E7C3A",
        "Resolve duplicate role=\"banner\" (remove JS-added banner role)",
        "Remove GeneratePress duplicate skip link",
        "Remove opacity: 0.8 from stat card source text",
    ]
    for item in p1:
        pdf.set_font("Helvetica", "", 9)
        pdf.set_text_color(60, 60, 60)
        pdf.cell(5, 5, "-", new_x="RIGHT")
        pdf.multi_cell(pdf.w - pdf.r_margin - pdf.get_x(), 5, item, new_x="LMARGIN", new_y="NEXT")

    pdf.ln(2)
    pdf.subsection("Priority 2 - Fix Soon (Major WCAG Failures)")
    p2 = [
        "Add aria-modal=\"true\" and aria-labelledby to chatbot dialog",
        "Fix search button and social links to 44x44px",
        "Fix aria-live=\"polite\" on stat counters",
        "Fix footer widget headings from <h4> to <h2>",
        "Resolve duplicate mobile menu toggle buttons",
    ]
    for item in p2:
        pdf.set_font("Helvetica", "", 9)
        pdf.set_text_color(60, 60, 60)
        pdf.cell(5, 5, "-", new_x="RIGHT")
        pdf.multi_cell(pdf.w - pdf.r_margin - pdf.get_x(), 5, item, new_x="LMARGIN", new_y="NEXT")

    pdf.ln(2)
    pdf.subsection("Priority 3 - Fix in Next Iteration (Minor)")
    p3 = [
        "Fix outline: none without :focus-visible guard on search input",
        "Fix gov banner toggle color contrast",
        "Fix .cst-animate opacity-0 fallback for no-JS",
        "Clean up hidden GP site-branding from accessibility tree",
        "Fix tag text color from #7FA35B to #5E7C3A",
    ]
    for item in p3:
        pdf.set_font("Helvetica", "", 9)
        pdf.set_text_color(60, 60, 60)
        pdf.cell(5, 5, "-", new_x="RIGHT")
        pdf.multi_cell(pdf.w - pdf.r_margin - pdf.get_x(), 5, item, new_x="LMARGIN", new_y="NEXT")

    # Save
    output_path = "/Users/ericbotperez/projects/cst-portals/docs/CST-Cannabis-Portal-ADA-Audit-Report.pdf"
    pdf.output(output_path)
    print(f"PDF saved to: {output_path}")


if __name__ == "__main__":
    main()
