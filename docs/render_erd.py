"""
Render ERD HTML diagram ke PNG menggunakan Playwright.
Output: erd-diagram.png (high resolution)
"""
import os
from playwright.sync_api import sync_playwright

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
HTML_FILE = os.path.join(BASE_DIR, "erd-diagram.html")
PNG_FILE = os.path.join(BASE_DIR, "erd-diagram.png")

def main():
    with sync_playwright() as p:
        # Coba chromium penuh dulu, fallback ke headless shell
        try:
            browser = p.chromium.launch()
        except Exception as e:
            print(f"Chromium penuh gagal ({e}), coba headless shell...")
            browser = p.chromium.launch(
                executable_path=r"C:\Users\HELLO\AppData\Local\ms-playwright\chromium_headless_shell-1223\chrome-headless-shell-win64\chrome-headless-shell.exe"
            )

        context = browser.new_context(
            viewport={"width": 1700, "height": 1300},
            device_scale_factor=2,
        )
        page = context.new_page()
        page.goto("file:///" + HTML_FILE.replace("\\", "/"))
        page.wait_for_load_state("networkidle")
        page.wait_for_timeout(500)

        page.screenshot(path=PNG_FILE, full_page=True, omit_background=False)
        browser.close()

    size_kb = round(os.path.getsize(PNG_FILE) / 1024, 1)
    print(f"OK - PNG saved: {PNG_FILE} ({size_kb} KB)")

if __name__ == "__main__":
    main()
