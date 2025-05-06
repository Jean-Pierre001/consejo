import customtkinter as ctk
from tkinter import messagebox
from PIL import Image  # Para manejar las imágenes

class FolderApp(ctk.CTk):

    def __init__(self):
        super().__init__()

        # Configuración inicial de la ventana
        self.geometry("1024x600")
        self.title("Pantalla de Notas")
        ctk.set_appearance_mode("Light")  # Modo claro por defecto
        ctk.set_default_color_theme("green")  # Tema de color por defecto

        # Rutas de los logos
        self.logo_claro = "log_claro.png"
        self.logo_oscuro = "log_oscuro.png"

        # Hacer la interfaz escalable
        self.grid_rowconfigure(0, weight=1)
        self.grid_columnconfigure(1, weight=1)

        # Crear el sidebar
        self.create_sidebar()

        # Crear el contenido principal
        self.create_main_content()

        # Actualizar la barra lateral según el modo
        self.update_sidebar_color()

    def create_sidebar(self):
        # Panel lateral
        self.sidebar_frame = ctk.CTkFrame(self, width=200, height=600, corner_radius=0)
        self.sidebar_frame.grid(row=0, column=0, sticky="ns")
        self.sidebar_frame.grid_rowconfigure(5, weight=1)

        # Logo en el panel lateral
        self.logo_label = ctk.CTkLabel(self.sidebar_frame, text="")
        self.logo_label.grid(row=0, column=0, padx=20, pady=(20, 10))
        self.update_logo()  # Actualizar el logo dependiendo del modo

        # Botones en el panel lateral
        self.home_button = ctk.CTkButton(self.sidebar_frame, text="Home", width=180, height=40, corner_radius=10)
        self.home_button.grid(row=1, column=0, padx=20, pady=10)

        self.schools_button = ctk.CTkButton(self.sidebar_frame, text="Escuelas", width=180, height=40, corner_radius=10)
        self.schools_button.grid(row=2, column=0, padx=20, pady=10)

        self.notes_button = ctk.CTkButton(self.sidebar_frame, text="Notas", width=180, height=40, corner_radius=10)
        self.notes_button.grid(row=3, column=0, padx=20, pady=10)

        # Botón para alternar entre modos claro/oscuro
        self.toggle_button = ctk.CTkButton(self.sidebar_frame, text="Alternar Modo", command=self.toggle_mode)
        self.toggle_button.grid(row=4, column=0, padx=20, pady=20)

    def create_main_content(self):
        # Contenedor principal para las carpetas
        self.content_frame = ctk.CTkFrame(self, corner_radius=10)
        self.content_frame.grid(row=0, column=1, padx=20, pady=20, sticky="nsew")
        self.content_frame.grid_rowconfigure(0, weight=1)
        self.content_frame.grid_columnconfigure(0, weight=1)

        # Crear el grid de carpetas
        folder_names = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]

        folder_frame = ctk.CTkFrame(self.content_frame)
        folder_frame.grid(row=0, column=0, padx=20, pady=20, sticky="nsew")

        # Cargar la imagen de la carpeta
        self.folder_image = ctk.CTkImage(Image.open("Folder.png").resize((50, 50)))

        # Crear las carpetas en un grid de 4 columnas
        self.folder_buttons = []
        for idx, month in enumerate(folder_names):
            row = idx // 4
            col = idx % 4
            folder_button = ctk.CTkButton(folder_frame, text=month, font=ctk.CTkFont(size=14), text_color="#A0C9A0",
                                          image=self.folder_image, compound="top",
                                          corner_radius=10, fg_color=self.get_folder_bg_color(), hover_color=self.get_hover_color(), width=150, height=150,
                                          command=lambda m=month: self.open_folder(m))
            folder_button.grid(row=row, column=col, padx=30, pady=20, sticky="nsew")
            self.folder_buttons.append(folder_button)

        # Asegurarse de que el grid sea escalable
        for i in range(3):  # 3 filas
            folder_frame.grid_rowconfigure(i, weight=1)
        for j in range(4):  # 4 columnas
            folder_frame.grid_columnconfigure(j, weight=1)

    def open_folder(self, month):
        messagebox.showinfo("Abrir carpeta", f"Has abierto la carpeta de {month}")

    # Alternar entre modo claro/oscuro
    def toggle_mode(self):
        current_mode = ctk.get_appearance_mode()
        if current_mode == "Light":
            ctk.set_appearance_mode("Dark")
        else:
            ctk.set_appearance_mode("Light")
        self.update_logo()  # Actualizar logo al cambiar de modo
        self.update_sidebar_color()  # Actualizar color de la barra lateral al cambiar de modo
        self.update_folder_colors()  # Actualizar colores de las carpetas al cambiar de modo

    # Actualizar el logo según el modo
    def update_logo(self):
        current_mode = ctk.get_appearance_mode()
        if current_mode == "Light":
            logo_image = ctk.CTkImage(Image.open(self.logo_claro), size=(180, 180))  # Tamaño ajustable
        else:
            logo_image = ctk.CTkImage(Image.open(self.logo_oscuro), size=(180, 180))
        self.logo_label.configure(image=logo_image)
        self.logo_label.image = logo_image  # Mantener referencia a la imagen

    # Actualizar el color de la barra lateral según el modo
    def update_sidebar_color(self):
        current_mode = ctk.get_appearance_mode()
        if current_mode == "Dark":
            self.sidebar_frame.configure(fg_color="#414141")  # Fondo oscuro
        else:
            self.sidebar_frame.configure(fg_color="white")  # Fondo claro

    # Obtener el color de fondo de las carpetas dependiendo del modo
    def get_folder_bg_color(self):
        current_mode = ctk.get_appearance_mode()
        if current_mode == "Light":
            return "#f0f0f0"  # Color claro para modo claro
        else:
            return "#333333"  # Color oscuro para modo oscuro

    # Obtener el color de hover de las carpetas dependiendo del modo
    def get_hover_color(self):
        current_mode = ctk.get_appearance_mode()
        if current_mode == "Light":
            return "#e0e0e0"  # Hover claro para modo claro
        else:
            return "#444444"  # Hover oscuro para modo oscuro

    # Actualizar los colores de las carpetas al cambiar de modo
    def update_folder_colors(self):
        for button in self.folder_buttons:
            button.configure(fg_color=self.get_folder_bg_color(), hover_color=self.get_hover_color())

if __name__ == "__main__":
    app = FolderApp()
    app.mainloop()
