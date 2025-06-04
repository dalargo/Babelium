erDiagram
    usuarios {
        int id PK
        enum tipo "alumno, profesor, admin"
        varchar identificador UK "NIA/DNI"
        varchar nombre
        varchar apellidos
        varchar email UK
        varchar password
        varchar foto
        datetime fecha_registro
        boolean activo
    }
    
    niveles_educativos {
        int id PK
        varchar nombre UK
        text descripcion
        int orden
        boolean activo
    }
    
    cursos {
        int id PK
        int nivel_id FK
        varchar nombre
        text descripcion
        int orden
        boolean activo
    }
    
    ramas {
        int id PK
        int nivel_id FK
        varchar nombre
        text descripcion
        boolean activo
    }
    
    modalidades_curso {
        int id PK
        int curso_id FK
        int rama_id FK
        varchar nombre
        text descripcion
        boolean activo
    }
    
    materias {
        int id PK
        int modalidad_curso_id FK
        varchar nombre
        text descripcion
        int creditos
        boolean obligatoria
        boolean activo
    }
    
    temas {
        int id PK
        int materia_id FK
        varchar titulo
        text descripcion
        int orden
        boolean activo
    }
    
    contenidos {
        int id PK
        int tema_id FK
        enum tipo "texto, imagen, video, archivo, enlace"
        varchar titulo
        text contenido
        varchar url
        int orden
        datetime fecha_creacion
        int creador_id FK
        boolean activo
    }
    
    matriculas {
        int id PK
        int usuario_id FK
        int modalidad_curso_id FK
        datetime fecha_matricula
        boolean activo
    }
    
    asignaciones_profesor {
        int id PK
        int profesor_id FK
        int materia_id FK
        datetime fecha_asignacion
        boolean activo
    }
    
    progreso_alumno {
        int id PK
        int usuario_id FK
        int contenido_id FK
        boolean completado
        int puntuacion
        datetime fecha_ultimo_acceso
    }
    
    comentarios {
        int id PK
        int usuario_id FK
        int contenido_id FK
        text comentario
        datetime fecha_comentario
        boolean activo
    }
    
    campos_dinamicos {
        int id PK
        varchar nombre
        enum tipo "texto, imagen, archivo"
        enum entidad "materia, tema, contenido"
        int entidad_id
        boolean activo
    }
    
    valores_campos_dinamicos {
        int id PK
        int campo_id FK
        text valor
        varchar url
        datetime fecha_creacion
        int creador_id FK
    }

    %% Relaciones principales
    niveles_educativos ||--o{ cursos : "tiene"
    niveles_educativos ||--o{ ramas : "contiene"
    cursos ||--o{ modalidades_curso : "forma"
    ramas ||--o{ modalidades_curso : "especializa"
    modalidades_curso ||--o{ materias : "incluye"
    materias ||--o{ temas : "contiene"
    temas ||--o{ contenidos : "tiene"
    
    %% Relaciones de usuarios
    usuarios ||--o{ contenidos : "crea"
    usuarios ||--o{ matriculas : "se_matricula"
    usuarios ||--o{ asignaciones_profesor : "asignado_a"
    usuarios ||--o{ progreso_alumno : "progresa_en"
    usuarios ||--o{ comentarios : "comenta"
    usuarios ||--o{ valores_campos_dinamicos : "crea_valor"
    
    %% Relaciones de contenido y progreso
    modalidades_curso ||--o{ matriculas : "recibe"
    materias ||--o{ asignaciones_profesor : "asignada_a"
    contenidos ||--o{ progreso_alumno : "seguido_por"
    contenidos ||--o{ comentarios : "recibe"
    
    %% Campos dinámicos
    campos_dinamicos ||--o{ valores_campos_dinamicos : "tiene_valores"
