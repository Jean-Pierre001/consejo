import sqlite3 as sql

conexion = sql.connect('consejo_escolar.db')

c = conexion.cursor()

c.execute('CREATE TABLE IF NOT EXISTS Escuelas (Escuelas_id INTEGER PRIMARY KEY AUTOINCREMENT, numero_escuela TEXT NOT NULL, nombre TEXT NOT NULL, direccion TEXT NOT NULL, categoria TEXT)')
c.execute('CREATE TABLE IF NOT EXISTS Directivos (Directivos_id INTEGER PRIMARY KEY AUTOINCREMENT, nombre TEXT NOT NULL, apellido TEXT NOT NULL, mail TEXT, numero_telefono INTEGER, cargo TEXT, id_escuela INTEGER, FOREIGN KEY (id_escuela) REFERENCES Escuelas(Escuelas_id))')
c.execute('CREATE TABLE IF NOT EXISTS Notas (Notas_id INTEGER PRIMARY KEY AUTOINCREMENT, solicitud TEXT, fecha TEXT, direccion_url TEXT, categoria TEXT, id_escuela INTEGER, FOREIGN KEY (id_escuela) REFERENCES Escuelas(Escuelas_id))')

conexion.commit()

conexion.close()