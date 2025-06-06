# 🎓 Babelium - Plataforma Educativa

Plataforma educativa moderna para la gestión de contenidos académicos, desarrollada con PHP y MySQL.

## ✨ Características

- 🏫 **Gestión de niveles educativos** - Primaria, ESO, Bachillerato, FP, Universidad
- 📚 **Organización jerárquica** - Niveles → Cursos → Modalidades → Materias → Temas → Contenidos
- 👥 **Sistema de usuarios** - Alumnos, Profesores y Administradores
- 🎨 **Interfaz moderna** - Diseño responsive e intuitivo
- ⚡ **Panel de administración** - Gestión completa del contenido
- 💬 **Foro integrado** - Comunicación entre usuarios por niveles y materias
- 🔍 **Explorador de estructura** - Visualización de la base de datos
- 👤 **Perfiles de usuario** - Con foto y datos personalizables

## 🚀 Instalación Rápida

### Opción 1: Instalación completa (Recomendada)

1. **Clonar el repositorio**
   \`\`\`bash
   git clone https://github.com/dalargo/Babelium.git
   cd babelium
   \`\`\`

2. **Crear base de datos**
   \`\`\`sql
   CREATE DATABASE babelium_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   \`\`\`

3. **Importar base de datos completa**
   \`\`\`bash
   mysql -u root -p babelium_db < scripts/babelium_db_completa.sql
   \`\`\`

4. **Configurar conexión**
   \`\`\`bash
   cp db/connection.example.php db/connection.php
   # Editar db/connection.php con tus credenciales
   \`\`\`

5. **¡Listo!** Accede a `http://localhost/babelium`

### Opción 2: Instalación paso a paso

Si prefieres instalar por partes, consulta [INSTALL.md](INSTALL.md) para instrucciones detalladas.

## 🔐 Usuarios de prueba

| Rol | Email | Contraseña | Descripción |
|-----|-------|------------|-------------|
| **Admin** | admin@babelium.edu | admin123 | Acceso completo al sistema |
| **Profesor** | profesor@babelium.edu | profesor123 | Gestión de contenidos |
| **Alumno** | alumno@babelium.edu | alumno123 | Visualización de contenidos |

## 🛠️ Tecnologías

- **Backend:** PHP 8+
- **Base de datos:** MySQL 8+
- **Frontend:** HTML5, CSS3, JavaScript
- **Iconos:** Font Awesome 6
- **Diseño:** CSS Grid, Flexbox
- **Responsive:** Adaptable a móviles, tablets y escritorio

## 📂 Estructura del proyecto

\`\`\`
babelium/
├── 📄 index.php                    # Página principal
├── 📄 niveles.php                  # Lista de niveles educativos
├── 📄 cursos.php                   # Lista de cursos
├── 📄 materias.php                 # Lista de materias
├── 📄 temas.php                    # Lista de temas
├── 📄 contenido.php                # Visualización de contenidos
├── 📄 sobre-nosotros.php           # Información sobre el proyecto
├── 📄 foro.php                     # Sistema de foro
├── 📄 foro-categoria.php           # Categorías del foro
├── 📄 foro-materia.php             # Foro por materias
├── 📄 foro-nivel.php               # Foro por niveles
├── 📄 foro-tema.php                # Temas del foro
├── 📁 admin/                       # Panel de administración
│   ├── 📄 dashboard.php            # Panel principal
│   ├── 📄 usuarios.php             # Gestión de usuarios
│   ├── 📄 niveles.php              # Gestión de niveles
│   ├── 📄 cursos.php               # Gestión de cursos
│   ├── 📄 modalidades.php          # Gestión de modalidades
│   ├── 📄 materias.php             # Gestión de materias
│   ├── 📄 temas.php                # Gestión de temas
│   ├── 📄 contenidos.php           # Gestión de contenidos
│   ├── 📄 estructura.php           # Explorador de BD
│   ├── 📄 perfil.php               # Perfil de administrador
│   └── 📄 footer.php               # Pie de página admin
├── 📁 auth/                        # Sistema de autenticación
│   ├── 📄 login.php                # Inicio de sesión
│   ├── 📄 logout.php               # Cierre de sesión
│   └── 📄 register.php             # Registro de usuarios
├── 📁 css/                         # Estilos CSS
│   ├── 📄 style.css                # Estilos generales
│   ├── 📄 reset.css                # Reset CSS
│   ├── 📄 admin.css                # Estilos de administración
│   ├── 📄 admin-responsive.css     # Responsive para admin
│   ├── 📄 admin-header.css         # Estilos del header admin
│   ├── 📄 admin-common.css         # Estilos comunes admin
│   ├── 📄 admin-estructura.css     # Estilos para estructura BD
│   ├── 📄 admin-perfil.css         # Estilos para perfil
│   └── 📄 foro.css                 # Estilos del foro
├── 📁 db/                          # Configuración de BD
│   ├── 📄 connection.php           # Conexión a la BD
│   └── 📄 connection.example.php   # Ejemplo de conexión
├── 📁 debug/                       # Herramientas de depuración
│   └── 📄 verificar_rutas.php      # Verificador de rutas
├── 📁 docs/                        # Documentación
│   └── 📄 database-er-diagram.md   # Diagrama ER de la BD
├── 📁 img/                         # Imágenes y recursos
├── 📁 includes/                    # Archivos compartidos
│   ├── 📄 header.php               # Cabecera del sitio
│   ├── 📄 footer.php               # Pie de página
│   ├── 📄 admin-header.php         # Cabecera de admin
│   └── 📄 auth-check.php           # Verificación de auth
├── 📁 js/                          # JavaScript
│   ├── 📄 admin-sidebar.js         # Control del sidebar
│   ├── 📄 niveles-animations.js    # Animaciones de niveles
│   ├── 📄 sobre-nosotros.js        # Scripts de sobre nosotros
│   └── 📄 foro.js                  # Funcionalidad del foro
├── 📁 php/                         # Funciones PHP
│   └── 📄 niveles-functions.php    # Funciones de niveles
└── 📁 scripts/                     # Scripts SQL
    ├── 📄 babelium_db_completa.sql # BD completa
    ├── 📄 babelium_database_v02.sql # Versión 2 de la BD
    ├── 📄 babelium_database_v03.sql # Versión 3 de la BD
    ├── 📄 crear_usuarios_demo_final.sql # Usuarios demo
    └── 📄 seed_niveles_educativos.sql # Datos de niveles
\`\`\`

## 📱 Responsive Design

- ✅ **Desktop** (1200px+) - Experiencia completa
- ✅ **Tablet** (768px - 1199px) - Interfaz adaptada
- ✅ **Mobile** (< 768px) - Diseño optimizado con menú hamburguesa

## 🎯 Estado del Proyecto

### ✅ Completado
- [x] Estructura de base de datos con relaciones
- [x] Sistema de autenticación seguro
- [x] Gestión completa de niveles educativos
- [x] Panel de administración funcional
- [x] Diseño responsive moderno
- [x] CSS organizado y optimizado
- [x] Eliminación en cascada
- [x] Exportación completa de BD
- [x] Sistema de foro
- [x] Explorador de estructura de BD
- [x] Perfiles de usuario con foto
- [x] Sidebar responsive con toggle

### 🚧 En desarrollo
- [ ] Sistema de progreso del usuario
- [ ] Sistema de favoritos
- [ ] Búsqueda avanzada
- [ ] Notificaciones
- [ ] Estadísticas y reportes
- [ ] Página de contenidos específicos
- [ ] Optimización de carga

### 🔮 Futuras mejoras
- [ ] API REST
- [ ] App móvil
- [ ] Integración con LMS
- [ ] Gamificación
- [ ] Análisis de aprendizaje

## 🗃️ Base de datos

### Archivos disponibles:

1. **`babelium_db_completa.sql`** ⭐ **Recomendado**
   - Exportación completa con todos los datos
   - Instalación en un solo paso
   - Incluye usuarios de prueba y contenido

2. **Instalación modular:**
   - `babelium_database_v03.sql` - Estructura de tablas actualizada
   - `seed_niveles_educativos.sql` - Datos de niveles
   - `crear_usuarios_demo_final.sql` - Usuarios de prueba
   - `crear_tablas_foro.sql` - Sistema de foro
   - `crear_tablas_intermedias.sql` - Tablas de relación

## 🚀 Despliegue

### Desarrollo local
\`\`\`bash
# Con XAMPP/WAMP
1. Copiar proyecto a htdocs/
2. Importar base de datos
3. Configurar connection.php
4. Acceder a http://localhost/babelium
\`\`\`

### Producción
\`\`\`bash
# Servidor Linux
1. Configurar Apache/Nginx
2. Configurar PHP 8+
3. Configurar MySQL
4. Configurar HTTPS
5. Cambiar contraseñas por defecto
\`\`\`

## 🤝 Contribuir

1. **Fork** el proyecto
2. **Crear** una rama para tu feature (`git checkout -b feature/nueva-funcionalidad`)
3. **Commit** tus cambios (`git commit -m '✨ Add nueva funcionalidad'`)
4. **Push** a la rama (`git push origin feature/nueva-funcionalidad`)
5. **Abrir** un Pull Request

### Convenciones de commits
- ✨ `:sparkles:` - Nueva funcionalidad
- 🐛 `:bug:` - Corrección de errores
- 🎨 `:art:` - Mejoras de UI/UX
- ⚡ `:zap:` - Mejoras de rendimiento
- 📝 `:memo:` - Documentación
- 🔧 `:wrench:` - Configuración

## 📄 Licencia

Este proyecto está bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para más detalles.

## 🙏 Agradecimientos

- Font Awesome por los iconos
- Comunidad PHP por las mejores prácticas
- Contribuidores del proyecto

## 📞 Soporte

- 🐛 **Issues:** [GitHub Issues](https://github.com/dalargo/Babelium/issues)
- 💬 **Discusiones:** [GitHub Discussions](https://github.com/dalargo/Babelium/discussions)
- 📧 **Email:** dalargo.dev@gmail.com

---

⭐ **¡Dale una estrella si te gusta el proyecto!** ⭐
