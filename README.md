# 🎓 Babelium - Plataforma Educativa

Plataforma educativa moderna para la gestión de contenidos académicos, desarrollada con PHP y MySQL.

## ✨ Características

- 🏫 **Gestión de niveles educativos** - Primaria, ESO, Bachillerato, FP, Universidad
- 📚 **Organización jerárquica** - Niveles → Cursos → Materias → Temas → Contenidos
- 👥 **Sistema de usuarios** - Alumnos, Profesores y Administradores
- 🎨 **Interfaz moderna** - Diseño responsive y intuitivo
- ⚡ **Panel de administración** - Gestión completa del contenido

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

## 📂 Estructura del proyecto

\`\`\`
babelium/
├── 📄 index.php                    # Página principal
├── 📄 niveles.php                  # Lista de niveles educativos
├── 📄 cursos.php                   # Lista de cursos
├── 📄 materias.php                 # Lista de materias
├── 📄 temas.php                    # Lista de temas
├── 📄 contenido.php                # Visualización de contenidos
├── 📁 auth/                        # Sistema de autenticación
├── 📁 admin/                       # Panel de administración
├── 📁 includes/                    # Archivos compartidos
├── 📁 db/                          # Configuración de BD
├── 📁 css/                         # Estilos organizados
├── 📁 scripts/                     # Scripts de base de datos
└── 📁 img/                         # Recursos gráficos
\`\`\`

## 📱 Responsive Design

- ✅ **Desktop** (1200px+) - Experiencia completa
- ✅ **Tablet** (768px - 1199px) - Interfaz adaptada
- ✅ **Mobile** (< 768px) - Diseño optimizado

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

### 🚧 En desarrollo
- [ ] Sistema de progreso del usuario
- [ ] Sistema de favoritos
- [ ] Búsqueda avanzada
- [ ] Notificaciones
- [ ] Estadísticas y reportes

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
   - `babelium_database.sql` - Estructura de tablas
   - `seed_niveles_educativos.sql` - Datos de niveles
   - `crear_usuarios_demo_final.sql` - Usuarios de prueba

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
- 📧 **Email:** tu-email@ejemplo.com

---

⭐ **¡Dale una estrella si te gusta el proyecto!** ⭐

