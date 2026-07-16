import sys, os
from playwright.sync_api import sync_playwright

html_path = os.path.abspath(r"C:\Users\HELLO\sutech\docs\erd_sutech.html")
pdf_path = os.path.abspath(r"C:\Users\HELLO\sutech\docs\ERD_Sutech_SmartUmrah.pdf")

with sync_playwright() as p:
    browser = p.chromium.launch()
    page = browser.new_page()
    page.goto("file:///" + html_path.replace("\\", "/"))
    # tunggu render
    page.wait_for_load_state("networkidle")
    page.pdf(
        path=pdf_path,
        format="A4",
        landscape=True,
        print_background=True,
        margin={"top": "0", "right": "0", "bottom": "0", "left": "0"},
    )
    browser.close()

size = os.path.getsize(pdf_path) / 1024
print(f"OK: {pdf_path} ({size:.1f} KB)")
