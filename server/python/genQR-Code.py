import qrcode
import qrcode.image.svg
import os

def generate_qr_svg(data, filename="qr_code.svg", output_dir="qrcodes_svg"):
    # Verzeichnis erstellen, falls nicht vorhanden
    os.makedirs(output_dir, exist_ok=True)

    # SVG-Renderer auswählen
    factory = qrcode.image.svg.SvgImage

    # QR-Code erzeugen mit SVG-Renderer
    img = qrcode.make(data, image_factory=factory)

    # Speichern
    path = os.path.join(output_dir, filename)
    with open(path, "wb") as f:
        img.save(f)

    print(f"QR-Code als SVG gespeichert unter: {path}")

# Beispiel-Nutzung
if __name__ == "__main__":
    generate_qr_svg("https://curiegymnasium.de", "example.svg")