import customtkinter as ctk
from PIL import Image

class FormApp(ctk.CTk):

    def __init__(self):
        super().__init__()

        # Configuración inicial de la ventana
        self.geometry("1024x600")
        self.title("Modificar Datos")
        ctk.set_appearance_mode("Light")  # Modo claro por defecto
        ctk.set_default_color_theme("green")  # Tema de color por defecto

        # Rutas de los logos e imagen del botón
        self.logo_claro = "C:/Users/E.E.S.T. N°1/Desktop/Consejo/log/log_claro.png"
        self.logo_oscuro = "C:/Users/E.E.S.T. N°1/Desktop/Consejo/log/log_oscuro.png"
        self.icono_guardar = "C:/Users/E.E.S.T. N°1/Desktop/Consejo/log//Guardar..png"

        # Hacer la interfaz escalable
        self.grid_rowconfigure(0, weight=1)
        self.grid_columnconfigure(1, weight=1)

        # Crear el sidebar
        self.create_sidebar()

        # Crear el contenido principal
        self.create_form()

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

    def create_form(self):
        # Frame principal para el formulario
        self.form_frame = ctk.CTkFrame(self, corner_radius=10)
        self.form_frame.grid(row=0, column=1, padx=20, pady=20, sticky="nsew")
        self.form_frame.grid_rowconfigure((0, 1, 2, 3, 4), weight=1)
        self.form_frame.grid_columnconfigure(1, weight=1)

        # Etiquetas y campos de entrada
        self.name_label = ctk.CTkLabel(self.form_frame, text="Nombre:")
        self.name_label.grid(row=0, column=0, padx=20, pady=10, sticky="e")

        self.name_entry = ctk.CTkEntry(self.form_frame, width=300)
        self.name_entry.grid(row=0, column=1, padx=20, pady=10)

        self.lastname_label = ctk.CTkLabel(self.form_frame, text="Apellido:")
        self.lastname_label.grid(row=1, column=0, padx=20, pady=10, sticky="e")

        self.lastname_entry = ctk.CTkEntry(self.form_frame, width=300)
        self.lastname_entry.grid(row=1, column=1, padx=20, pady=10)

        self.phone_label = ctk.CTkLabel(self.form_frame, text="Teléfono:")
        self.phone_label.grid(row=2, column=0, padx=20, pady=10, sticky="e")

        self.phone_entry = ctk.CTkEntry(self.form_frame, width=300)
        self.phone_entry.grid(row=2, column=1, padx=20, pady=10)

        self.mail_label = ctk.CTkLabel(self.form_frame, text="Mail:")
        self.mail_label.grid(row=3, column=0, padx=20, pady=10, sticky="e")

        self.mail_entry = ctk.CTkEntry(self.form_frame, width=300)
        self.mail_entry.grid(row=3, column=1, padx=20, pady=10)

        self.position_label = ctk.CTkLabel(self.form_frame, text="Cargo:")
        self.position_label.grid(row=4, column=0, padx=20, pady=10, sticky="e")

        self.position_entry = ctk.CTkEntry(self.form_frame, width=300)
        self.position_entry.grid(row=4, column=1, padx=20, pady=10)

        # Botones Guardar y Cancelar
        self.cancel_button = ctk.CTkButton(self.form_frame, text="✖", width=40, fg_color="red", corner_radius=10, command=self.cancel)
        self.cancel_button.grid(row=5, column=0, padx=20, pady=20, sticky="w")

        guardar_image = ctk.CTkImage(Image.open(self.icono_guardar), size=(20, 20))
        self.save_button = ctk.CTkButton(self.form_frame, text="", image=guardar_image, width=40, corner_radius=10, command=self.save_data)
        self.save_button.grid(row=5, column=1, padx=20, pady=20, sticky="e")

    def save_data(self):
        print("Datos guardados")

    def cancel(self):
        print("Acción cancelada")

    # Alternar entre modo claro/oscuro
    def toggle_mode(self):
        current_mode = ctk.get_appearance_mode()
        new_mode = "Dark" if current_mode == "Light" else "Light"
        ctk.set_appearance_mode(new_mode)
        self.update_logo()  # Actualizar logo al cambiar de modo
        self.update_sidebar_color()  # Actualizar color de la barra lateral al cambiar de modo

    # Actualizar el logo según el modo
    def update_logo(self):
        current_mode = ctk.get_appearance_mode()
        logo_path = self.logo_claro if current_mode == "Light" else self.logo_oscuro
        logo_image = ctk.CTkImage(Image.open(logo_path), size=(180, 180))
        self.logo_label.configure(image=logo_image)
        self.logo_label.image = logo_image  # Mantener referencia a la imagen

    # Actualizar el color de la barra lateral según el modo
    def update_sidebar_color(self):
        current_mode = ctk.get_appearance_mode()
        self.sidebar_frame.configure(fg_color="#414141" if current_mode == "Dark" else "white")

if __name__ == "__main__":
    app = FormApp()
    app.mainloop()
