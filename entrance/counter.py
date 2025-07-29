import flet as ft

def main(page: ft.Page):
    page.title = "Komplexes Layout mit Flet"
    page.padding = 20
    page.scroll = "auto"

    page.add(
        ft.Row(
            controls=[
                # Sidebar
                ft.Container(
                    content=ft.Text("Sidebar"),
                    bgcolor="blue200",
                    width=200,
                    padding=10
                ),
                # Hauptinhalt mit zwei Bereichen
                ft.Expanded(
                    child=ft.Column(
                        controls=[
                            ft.Container(
                                content=ft.Text("Hauptbereich oben"),
                                bgcolor="green200",
                                height=150,
                                padding=10
                            ),
                            ft.Container(
                                content=ft.Text("Hauptbereich unten"),
                                bgcolor="green100",
                                expand=True,
                                padding=10
                            )
                        ]
                    )
                ),
                # Rechte Seitenleiste
                ft.Container(
                    content=ft.Text("Zusatzinfos"),
                    bgcolor="amber200",
                    width=150,
                    padding=10
                )
            ],
            expand=True,
            spacing=10
        )
    )

ft.app(target=main)
