import customtkinter as ctk
from PIL import Image
from notas import FolderApp  # Asegúrate de que FolderApp esté bien definida en el archivo notas.py

class SchoolApp(ctk.CTk):

    def __init__(self):
        super().__init__()

        # Configuración inicial de la ventana
        self.geometry("1024x600")
        self.title("Pantalla de Escuelas")
        ctk.set_appearance_mode("Light")  # Modo claro por defecto
        ctk.set_default_color_theme("green")  # Tema de color por defecto

        # Configurar layout
        self.grid_rowconfigure(0, weight=1)
        self.grid_columnconfigure(1, weight=1)

        # Crear el sidebar y el contenido principal
        self.create_sidebar()
        self.create_content_frame()
        self.update_sidebar_color()

    def create_sidebar(self):
        # Panel lateral
        self.sidebar_frame = ctk.CTkFrame(self, width=200, height=600, corner_radius=0)
        self.sidebar_frame.grid(row=0, column=0, sticky="ns")
        self.sidebar_frame.grid_rowconfigure(5, weight=1)

        # Logo en el panel lateral
        self.logo_label = ctk.CTkLabel(self.sidebar_frame, text="")
        self.logo_label.grid(row=0, column=0, padx=20, pady=(20, 10))
        self.update_logo()

        # Botones en el panel lateral
        self.home_button = ctk.CTkButton(self.sidebar_frame, text="Home", width=180, height=40, corner_radius=10)
        self.home_button.grid(row=1, column=0, padx=20, pady=10)

        self.schools_button = ctk.CTkButton(self.sidebar_frame, text="Escuelas", width=180, height=40, corner_radius=10)
        self.schools_button.grid(row=2, column=0, padx=20, pady=10)

        self.notes_button = ctk.CTkButton(self.sidebar_frame, text="Notas", width=180, height=40, corner_radius=10, command=self.open_notes)
        self.notes_button.grid(row=3, column=0, padx=20, pady=10)

        # Botón para alternar entre modos claro/oscuro
        self.toggle_button = ctk.CTkButton(self.sidebar_frame, text="Alternar Modo", command=self.toggle_mode)
        self.toggle_button.grid(row=4, column=0, padx=20, pady=20)

    def create_content_frame(self):
        # Este es el frame donde iría el contenido específico de "Escuelas"
        self.content_frame = ctk.CTkFrame(self, corner_radius=10)
        self.content_frame.grid(row=0, column=1, padx=20, pady=20, sticky="nsew")
        # Puedes agregar más widgets en este frame según sea necesario

    def open_notes(self):
        # Cerrar la ventana actual y abrir la ventana de Notas
        self.destroy()  # Cierra la ventana de Escuelas
        notes_app = FolderApp()  # Crear una instancia de la app de Notas
        notes_app.mainloop()  # Ejecutar la ventana de Notas

    def toggle_mode(self):
        # Alternar entre el modo claro y oscuro
        current_mode = ctk.get_appearance_mode()
        new_mode = "Dark" if current_mode == "Light" else "Light"
        ctk.set_appearance_mode(new_mode)
        self.update_logo()  # Actualizar el logo al cambiar de modo
        self.update_sidebar_color()  # Actualizar el color de la barra lateral al cambiar de modo

    def update_logo(self):
        # Actualizar el logo según el modo
        current_mode = ctk.get_appearance_mode()
        logo_path = "path_to_logo_light.png" if current_mode == "Light" else "path_to_logo_dark.png"
        logo_image = ctk.CTkImage(Image.open(logo_path), size=(180, 180))
        self.logo_label.configure(image=logo_image)
        self.logo_label.image = logo_image  # Mantener la referencia a la imagen

    def update_sidebar_color(self):
        # Actualizar el color de la barra lateral según el modo
        current_mode = ctk.get_appearance_mode()
        self.sidebar_frame.configure(fg_color="#414141" if current_mode == "Dark" else "white")

if __name__ == "__main__":
    app = SchoolApp()
    app.mainloop()
