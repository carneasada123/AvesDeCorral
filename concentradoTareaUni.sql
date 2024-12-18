PGDMP      %                 |            concentradoTareaUni    16.1    16.1 �    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    99148    concentradoTareaUni    DATABASE     �   CREATE DATABASE "concentradoTareaUni" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Latin America.utf8';
 %   DROP DATABASE "concentradoTareaUni";
                postgres    false            �            1259    99149    entrega_parcial_can    TABLE     @  CREATE TABLE public.entrega_parcial_can (
    id_epc integer NOT NULL,
    cantidad character varying(255),
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    fk_usuario integer,
    comentario character varying(255),
    fecha_entrega date,
    recibe character varying(255)
);
 '   DROP TABLE public.entrega_parcial_can;
       public         heap    postgres    false            �            1259    99154    entrega_parcial_can_id_epc_seq    SEQUENCE     �   CREATE SEQUENCE public.entrega_parcial_can_id_epc_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 5   DROP SEQUENCE public.entrega_parcial_can_id_epc_seq;
       public          postgres    false    215            �           0    0    entrega_parcial_can_id_epc_seq    SEQUENCE OWNED BY     a   ALTER SEQUENCE public.entrega_parcial_can_id_epc_seq OWNED BY public.entrega_parcial_can.id_epc;
          public          postgres    false    216            �            1259    99155    entregas    TABLE     Z   CREATE TABLE public.entregas (
    id_entrega integer NOT NULL,
    fecha_entrega date
);
    DROP TABLE public.entregas;
       public         heap    postgres    false            �            1259    99158    entregas_id_entrega_seq    SEQUENCE     �   CREATE SEQUENCE public.entregas_id_entrega_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.entregas_id_entrega_seq;
       public          postgres    false    217            �           0    0    entregas_id_entrega_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.entregas_id_entrega_seq OWNED BY public.entregas.id_entrega;
          public          postgres    false    218            �            1259    99159    estados    TABLE     l   CREATE TABLE public.estados (
    id_estado integer NOT NULL,
    estado character varying(255) NOT NULL
);
    DROP TABLE public.estados;
       public         heap    postgres    false            �            1259    99162    estados_id_estado_seq    SEQUENCE     �   CREATE SEQUENCE public.estados_id_estado_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.estados_id_estado_seq;
       public          postgres    false    219            �           0    0    estados_id_estado_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.estados_id_estado_seq OWNED BY public.estados.id_estado;
          public          postgres    false    220            �            1259    99163    estados_servicios    TABLE     {   CREATE TABLE public.estados_servicios (
    id_estado_servicio integer NOT NULL,
    descripcion character varying(255)
);
 %   DROP TABLE public.estados_servicios;
       public         heap    postgres    false            �            1259    99166 (   estados_servicios_id_estado_servicio_seq    SEQUENCE     �   CREATE SEQUENCE public.estados_servicios_id_estado_servicio_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ?   DROP SEQUENCE public.estados_servicios_id_estado_servicio_seq;
       public          postgres    false    221            �           0    0 (   estados_servicios_id_estado_servicio_seq    SEQUENCE OWNED BY     u   ALTER SEQUENCE public.estados_servicios_id_estado_servicio_seq OWNED BY public.estados_servicios.id_estado_servicio;
          public          postgres    false    222            �            1259    99167    failed_jobs    TABLE     &  CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);
    DROP TABLE public.failed_jobs;
       public         heap    postgres    false            �            1259    99173    failed_jobs_id_seq    SEQUENCE     {   CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.failed_jobs_id_seq;
       public          postgres    false    223            �           0    0    failed_jobs_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;
          public          postgres    false    224            �            1259    99174    inicios    TABLE     W   CREATE TABLE public.inicios (
    id_inicio integer NOT NULL,
    fecha_inicio date
);
    DROP TABLE public.inicios;
       public         heap    postgres    false            �            1259    99177    inicios_id_inicio_seq    SEQUENCE     �   CREATE SEQUENCE public.inicios_id_inicio_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.inicios_id_inicio_seq;
       public          postgres    false    225            �           0    0    inicios_id_inicio_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.inicios_id_inicio_seq OWNED BY public.inicios.id_inicio;
          public          postgres    false    226            �            1259    99178    material_status    TABLE     g   CREATE TABLE public.material_status (
    id_ms integer NOT NULL,
    status character varying(255)
);
 #   DROP TABLE public.material_status;
       public         heap    postgres    false            �            1259    99181    material_status_id_ms_seq    SEQUENCE     �   CREATE SEQUENCE public.material_status_id_ms_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.material_status_id_ms_seq;
       public          postgres    false    227            �           0    0    material_status_id_ms_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.material_status_id_ms_seq OWNED BY public.material_status.id_ms;
          public          postgres    false    228            �            1259    99182 
   materiales    TABLE     �   CREATE TABLE public.materiales (
    id_material integer NOT NULL,
    codigo character varying,
    descripcion character varying,
    fk_tp integer
);
    DROP TABLE public.materiales;
       public         heap    postgres    false            �            1259    99187    materiales_can    TABLE     �   CREATE TABLE public.materiales_can (
    id_mc integer NOT NULL,
    fk_material integer,
    cantidad character varying,
    fk_ms integer
);
 "   DROP TABLE public.materiales_can;
       public         heap    postgres    false            �            1259    99192    materiales_can_id_mc_seq    SEQUENCE     �   CREATE SEQUENCE public.materiales_can_id_mc_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.materiales_can_id_mc_seq;
       public          postgres    false    230            �           0    0    materiales_can_id_mc_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.materiales_can_id_mc_seq OWNED BY public.materiales_can.id_mc;
          public          postgres    false    231            �            1259    99193    materiales_id_material_seq    SEQUENCE     �   CREATE SEQUENCE public.materiales_id_material_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE public.materiales_id_material_seq;
       public          postgres    false    229            �           0    0    materiales_id_material_seq    SEQUENCE OWNED BY     Y   ALTER SEQUENCE public.materiales_id_material_seq OWNED BY public.materiales.id_material;
          public          postgres    false    232            �            1259    99194 
   migrations    TABLE     �   CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);
    DROP TABLE public.migrations;
       public         heap    postgres    false            �            1259    99197    migrations_id_seq    SEQUENCE     �   CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.migrations_id_seq;
       public          postgres    false    233            �           0    0    migrations_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;
          public          postgres    false    234            �            1259    99198    parcial_mat    TABLE     p   CREATE TABLE public.parcial_mat (
    id_parcial_mat integer NOT NULL,
    fk_epc integer,
    fk_mc integer
);
    DROP TABLE public.parcial_mat;
       public         heap    postgres    false            �            1259    99201    parcial_mat_id_parcial_mat_seq    SEQUENCE     �   CREATE SEQUENCE public.parcial_mat_id_parcial_mat_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 5   DROP SEQUENCE public.parcial_mat_id_parcial_mat_seq;
       public          postgres    false    235            �           0    0    parcial_mat_id_parcial_mat_seq    SEQUENCE OWNED BY     a   ALTER SEQUENCE public.parcial_mat_id_parcial_mat_seq OWNED BY public.parcial_mat.id_parcial_mat;
          public          postgres    false    236            �            1259    99202    password_reset_tokens    TABLE     �   CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);
 )   DROP TABLE public.password_reset_tokens;
       public         heap    postgres    false            �            1259    99207    personal_access_tokens    TABLE     �  CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 *   DROP TABLE public.personal_access_tokens;
       public         heap    postgres    false            �            1259    99212    personal_access_tokens_id_seq    SEQUENCE     �   CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 4   DROP SEQUENCE public.personal_access_tokens_id_seq;
       public          postgres    false    238            �           0    0    personal_access_tokens_id_seq    SEQUENCE OWNED BY     _   ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;
          public          postgres    false    239            �            1259    99213    personas    TABLE     d  CREATE TABLE public.personas (
    id_persona integer NOT NULL,
    nombre character varying(255) NOT NULL,
    apellido_paterno character varying(255),
    apellido_materno character varying(255),
    fecha_registro date,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    remember_token character varying(100)
);
    DROP TABLE public.personas;
       public         heap    postgres    false            �            1259    99218    personas_id_persona_seq    SEQUENCE     �   CREATE SEQUENCE public.personas_id_persona_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.personas_id_persona_seq;
       public          postgres    false    240            �           0    0    personas_id_persona_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.personas_id_persona_seq OWNED BY public.personas.id_persona;
          public          postgres    false    241            �            1259    99219    roles    TABLE     l   CREATE TABLE public.roles (
    id_rol integer NOT NULL,
    descripcion character varying(255) NOT NULL
);
    DROP TABLE public.roles;
       public         heap    postgres    false            �            1259    99222    roles_id_rol_seq    SEQUENCE     �   CREATE SEQUENCE public.roles_id_rol_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.roles_id_rol_seq;
       public          postgres    false    242            �           0    0    roles_id_rol_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.roles_id_rol_seq OWNED BY public.roles.id_rol;
          public          postgres    false    243            �            1259    99223    ser_mat_can    TABLE     m   CREATE TABLE public.ser_mat_can (
    id_smc integer NOT NULL,
    fk_servicio integer,
    fk_mc integer
);
    DROP TABLE public.ser_mat_can;
       public         heap    postgres    false            �            1259    99226    ser_mat_can_id_smc_seq    SEQUENCE     �   CREATE SEQUENCE public.ser_mat_can_id_smc_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.ser_mat_can_id_smc_seq;
       public          postgres    false    244            �           0    0    ser_mat_can_id_smc_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.ser_mat_can_id_smc_seq OWNED BY public.ser_mat_can.id_smc;
          public          postgres    false    245            �            1259    99227 	   servicios    TABLE     �  CREATE TABLE public.servicios (
    id_servicio integer NOT NULL,
    cct character varying,
    fk_trimestre integer,
    fk_tipo_servicio integer,
    fk_usuario integer,
    ano integer,
    fk_estado_servicio integer,
    folio character varying,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    fk_inicio integer,
    fk_entrega integer,
    fk_usuario_editor integer
);
    DROP TABLE public.servicios;
       public         heap    postgres    false            �            1259    99232    servicios_id_servicio_seq    SEQUENCE     �   CREATE SEQUENCE public.servicios_id_servicio_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.servicios_id_servicio_seq;
       public          postgres    false    246            �           0    0    servicios_id_servicio_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.servicios_id_servicio_seq OWNED BY public.servicios.id_servicio;
          public          postgres    false    247            �            1259    99233    tipos_presentacion    TABLE     j   CREATE TABLE public.tipos_presentacion (
    id_tp integer NOT NULL,
    descripcion character varying
);
 &   DROP TABLE public.tipos_presentacion;
       public         heap    postgres    false            �            1259    99238    tipos_presentacion_id_tp_seq    SEQUENCE     �   CREATE SEQUENCE public.tipos_presentacion_id_tp_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 3   DROP SEQUENCE public.tipos_presentacion_id_tp_seq;
       public          postgres    false    248            �           0    0    tipos_presentacion_id_tp_seq    SEQUENCE OWNED BY     ]   ALTER SEQUENCE public.tipos_presentacion_id_tp_seq OWNED BY public.tipos_presentacion.id_tp;
          public          postgres    false    249            �            1259    99239    tipos_servicios    TABLE     m   CREATE TABLE public.tipos_servicios (
    id_servicio integer NOT NULL,
    descripcion character varying
);
 #   DROP TABLE public.tipos_servicios;
       public         heap    postgres    false            �            1259    99244    tipos_servicios_id_servicio_seq    SEQUENCE     �   CREATE SEQUENCE public.tipos_servicios_id_servicio_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE public.tipos_servicios_id_servicio_seq;
       public          postgres    false    250            �           0    0    tipos_servicios_id_servicio_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE public.tipos_servicios_id_servicio_seq OWNED BY public.tipos_servicios.id_servicio;
          public          postgres    false    251            �            1259    99245 
   trimestres    TABLE     i   CREATE TABLE public.trimestres (
    id_trimestre integer NOT NULL,
    descripcion character varying
);
    DROP TABLE public.trimestres;
       public         heap    postgres    false            �            1259    99250    trimestres_id_trimestre_seq    SEQUENCE     �   CREATE SEQUENCE public.trimestres_id_trimestre_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE public.trimestres_id_trimestre_seq;
       public          postgres    false    252            �           0    0    trimestres_id_trimestre_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE public.trimestres_id_trimestre_seq OWNED BY public.trimestres.id_trimestre;
          public          postgres    false    253            �            1259    99251    users    TABLE     x  CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.users;
       public         heap    postgres    false            �            1259    99256    users_id_seq    SEQUENCE     u   CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.users_id_seq;
       public          postgres    false    254            �           0    0    users_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;
          public          postgres    false    255                        1259    99257    usuarios    TABLE     r  CREATE TABLE public.usuarios (
    id_usuario integer NOT NULL,
    usuario character varying(255) NOT NULL,
    clave character varying(255) NOT NULL,
    fk_persona integer NOT NULL,
    fk_estado integer NOT NULL,
    fk_rol integer,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    remember_token character varying(100)
);
    DROP TABLE public.usuarios;
       public         heap    postgres    false                       1259    99262    usuarios_id_usuario_seq    SEQUENCE     �   CREATE SEQUENCE public.usuarios_id_usuario_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.usuarios_id_usuario_seq;
       public          postgres    false    256            �           0    0    usuarios_id_usuario_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.usuarios_id_usuario_seq OWNED BY public.usuarios.id_usuario;
          public          postgres    false    257            �           2604    99263    entrega_parcial_can id_epc    DEFAULT     �   ALTER TABLE ONLY public.entrega_parcial_can ALTER COLUMN id_epc SET DEFAULT nextval('public.entrega_parcial_can_id_epc_seq'::regclass);
 I   ALTER TABLE public.entrega_parcial_can ALTER COLUMN id_epc DROP DEFAULT;
       public          postgres    false    216    215            �           2604    99264    entregas id_entrega    DEFAULT     z   ALTER TABLE ONLY public.entregas ALTER COLUMN id_entrega SET DEFAULT nextval('public.entregas_id_entrega_seq'::regclass);
 B   ALTER TABLE public.entregas ALTER COLUMN id_entrega DROP DEFAULT;
       public          postgres    false    218    217            �           2604    99265    estados id_estado    DEFAULT     v   ALTER TABLE ONLY public.estados ALTER COLUMN id_estado SET DEFAULT nextval('public.estados_id_estado_seq'::regclass);
 @   ALTER TABLE public.estados ALTER COLUMN id_estado DROP DEFAULT;
       public          postgres    false    220    219            �           2604    99266 $   estados_servicios id_estado_servicio    DEFAULT     �   ALTER TABLE ONLY public.estados_servicios ALTER COLUMN id_estado_servicio SET DEFAULT nextval('public.estados_servicios_id_estado_servicio_seq'::regclass);
 S   ALTER TABLE public.estados_servicios ALTER COLUMN id_estado_servicio DROP DEFAULT;
       public          postgres    false    222    221            �           2604    99267    failed_jobs id    DEFAULT     p   ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);
 =   ALTER TABLE public.failed_jobs ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    224    223            �           2604    99268    inicios id_inicio    DEFAULT     v   ALTER TABLE ONLY public.inicios ALTER COLUMN id_inicio SET DEFAULT nextval('public.inicios_id_inicio_seq'::regclass);
 @   ALTER TABLE public.inicios ALTER COLUMN id_inicio DROP DEFAULT;
       public          postgres    false    226    225            �           2604    99269    material_status id_ms    DEFAULT     ~   ALTER TABLE ONLY public.material_status ALTER COLUMN id_ms SET DEFAULT nextval('public.material_status_id_ms_seq'::regclass);
 D   ALTER TABLE public.material_status ALTER COLUMN id_ms DROP DEFAULT;
       public          postgres    false    228    227            �           2604    99270    materiales id_material    DEFAULT     �   ALTER TABLE ONLY public.materiales ALTER COLUMN id_material SET DEFAULT nextval('public.materiales_id_material_seq'::regclass);
 E   ALTER TABLE public.materiales ALTER COLUMN id_material DROP DEFAULT;
       public          postgres    false    232    229            �           2604    99271    materiales_can id_mc    DEFAULT     |   ALTER TABLE ONLY public.materiales_can ALTER COLUMN id_mc SET DEFAULT nextval('public.materiales_can_id_mc_seq'::regclass);
 C   ALTER TABLE public.materiales_can ALTER COLUMN id_mc DROP DEFAULT;
       public          postgres    false    231    230            �           2604    99272    migrations id    DEFAULT     n   ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);
 <   ALTER TABLE public.migrations ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    234    233            �           2604    99273    parcial_mat id_parcial_mat    DEFAULT     �   ALTER TABLE ONLY public.parcial_mat ALTER COLUMN id_parcial_mat SET DEFAULT nextval('public.parcial_mat_id_parcial_mat_seq'::regclass);
 I   ALTER TABLE public.parcial_mat ALTER COLUMN id_parcial_mat DROP DEFAULT;
       public          postgres    false    236    235            �           2604    99274    personal_access_tokens id    DEFAULT     �   ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);
 H   ALTER TABLE public.personal_access_tokens ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    239    238            �           2604    99275    personas id_persona    DEFAULT     z   ALTER TABLE ONLY public.personas ALTER COLUMN id_persona SET DEFAULT nextval('public.personas_id_persona_seq'::regclass);
 B   ALTER TABLE public.personas ALTER COLUMN id_persona DROP DEFAULT;
       public          postgres    false    241    240            �           2604    99276    roles id_rol    DEFAULT     l   ALTER TABLE ONLY public.roles ALTER COLUMN id_rol SET DEFAULT nextval('public.roles_id_rol_seq'::regclass);
 ;   ALTER TABLE public.roles ALTER COLUMN id_rol DROP DEFAULT;
       public          postgres    false    243    242            �           2604    99277    ser_mat_can id_smc    DEFAULT     x   ALTER TABLE ONLY public.ser_mat_can ALTER COLUMN id_smc SET DEFAULT nextval('public.ser_mat_can_id_smc_seq'::regclass);
 A   ALTER TABLE public.ser_mat_can ALTER COLUMN id_smc DROP DEFAULT;
       public          postgres    false    245    244            �           2604    99278    servicios id_servicio    DEFAULT     ~   ALTER TABLE ONLY public.servicios ALTER COLUMN id_servicio SET DEFAULT nextval('public.servicios_id_servicio_seq'::regclass);
 D   ALTER TABLE public.servicios ALTER COLUMN id_servicio DROP DEFAULT;
       public          postgres    false    247    246            �           2604    99279    tipos_presentacion id_tp    DEFAULT     �   ALTER TABLE ONLY public.tipos_presentacion ALTER COLUMN id_tp SET DEFAULT nextval('public.tipos_presentacion_id_tp_seq'::regclass);
 G   ALTER TABLE public.tipos_presentacion ALTER COLUMN id_tp DROP DEFAULT;
       public          postgres    false    249    248            �           2604    99280    tipos_servicios id_servicio    DEFAULT     �   ALTER TABLE ONLY public.tipos_servicios ALTER COLUMN id_servicio SET DEFAULT nextval('public.tipos_servicios_id_servicio_seq'::regclass);
 J   ALTER TABLE public.tipos_servicios ALTER COLUMN id_servicio DROP DEFAULT;
       public          postgres    false    251    250            �           2604    99281    trimestres id_trimestre    DEFAULT     �   ALTER TABLE ONLY public.trimestres ALTER COLUMN id_trimestre SET DEFAULT nextval('public.trimestres_id_trimestre_seq'::regclass);
 F   ALTER TABLE public.trimestres ALTER COLUMN id_trimestre DROP DEFAULT;
       public          postgres    false    253    252            �           2604    99282    users id    DEFAULT     d   ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 7   ALTER TABLE public.users ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    255    254            �           2604    99283    usuarios id_usuario    DEFAULT     z   ALTER TABLE ONLY public.usuarios ALTER COLUMN id_usuario SET DEFAULT nextval('public.usuarios_id_usuario_seq'::regclass);
 B   ALTER TABLE public.usuarios ALTER COLUMN id_usuario DROP DEFAULT;
       public          postgres    false    257    256            �          0    99149    entrega_parcial_can 
   TABLE DATA           �   COPY public.entrega_parcial_can (id_epc, cantidad, created_at, updated_at, fk_usuario, comentario, fecha_entrega, recibe) FROM stdin;
    public          postgres    false    215   4�       �          0    99155    entregas 
   TABLE DATA           =   COPY public.entregas (id_entrega, fecha_entrega) FROM stdin;
    public          postgres    false    217   ��       �          0    99159    estados 
   TABLE DATA           4   COPY public.estados (id_estado, estado) FROM stdin;
    public          postgres    false    219   ��       �          0    99163    estados_servicios 
   TABLE DATA           L   COPY public.estados_servicios (id_estado_servicio, descripcion) FROM stdin;
    public          postgres    false    221   *�       �          0    99167    failed_jobs 
   TABLE DATA           a   COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
    public          postgres    false    223   V�       �          0    99174    inicios 
   TABLE DATA           :   COPY public.inicios (id_inicio, fecha_inicio) FROM stdin;
    public          postgres    false    225   s�       �          0    99178    material_status 
   TABLE DATA           8   COPY public.material_status (id_ms, status) FROM stdin;
    public          postgres    false    227   %�       �          0    99182 
   materiales 
   TABLE DATA           M   COPY public.materiales (id_material, codigo, descripcion, fk_tp) FROM stdin;
    public          postgres    false    229   `�       �          0    99187    materiales_can 
   TABLE DATA           M   COPY public.materiales_can (id_mc, fk_material, cantidad, fk_ms) FROM stdin;
    public          postgres    false    230   ��       �          0    99194 
   migrations 
   TABLE DATA           :   COPY public.migrations (id, migration, batch) FROM stdin;
    public          postgres    false    233   �       �          0    99198    parcial_mat 
   TABLE DATA           D   COPY public.parcial_mat (id_parcial_mat, fk_epc, fk_mc) FROM stdin;
    public          postgres    false    235   ��       �          0    99202    password_reset_tokens 
   TABLE DATA           I   COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
    public          postgres    false    237   ��       �          0    99207    personal_access_tokens 
   TABLE DATA           �   COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
    public          postgres    false    238   ��       �          0    99213    personas 
   TABLE DATA           �   COPY public.personas (id_persona, nombre, apellido_paterno, apellido_materno, fecha_registro, created_at, updated_at, remember_token) FROM stdin;
    public          postgres    false    240   �       �          0    99219    roles 
   TABLE DATA           4   COPY public.roles (id_rol, descripcion) FROM stdin;
    public          postgres    false    242   e�       �          0    99223    ser_mat_can 
   TABLE DATA           A   COPY public.ser_mat_can (id_smc, fk_servicio, fk_mc) FROM stdin;
    public          postgres    false    244   ��       �          0    99227 	   servicios 
   TABLE DATA           �   COPY public.servicios (id_servicio, cct, fk_trimestre, fk_tipo_servicio, fk_usuario, ano, fk_estado_servicio, folio, created_at, updated_at, fk_inicio, fk_entrega, fk_usuario_editor) FROM stdin;
    public          postgres    false    246   ��       �          0    99233    tipos_presentacion 
   TABLE DATA           @   COPY public.tipos_presentacion (id_tp, descripcion) FROM stdin;
    public          postgres    false    248   ��       �          0    99239    tipos_servicios 
   TABLE DATA           C   COPY public.tipos_servicios (id_servicio, descripcion) FROM stdin;
    public          postgres    false    250   ��       �          0    99245 
   trimestres 
   TABLE DATA           ?   COPY public.trimestres (id_trimestre, descripcion) FROM stdin;
    public          postgres    false    252   I�       �          0    99251    users 
   TABLE DATA           u   COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at) FROM stdin;
    public          postgres    false    254   ��       �          0    99257    usuarios 
   TABLE DATA           �   COPY public.usuarios (id_usuario, usuario, clave, fk_persona, fk_estado, fk_rol, created_at, updated_at, remember_token) FROM stdin;
    public          postgres    false    256   ��       �           0    0    entrega_parcial_can_id_epc_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('public.entrega_parcial_can_id_epc_seq', 253, true);
          public          postgres    false    216            �           0    0    entregas_id_entrega_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('public.entregas_id_entrega_seq', 275, true);
          public          postgres    false    218            �           0    0    estados_id_estado_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.estados_id_estado_seq', 1, false);
          public          postgres    false    220            �           0    0 (   estados_servicios_id_estado_servicio_seq    SEQUENCE SET     V   SELECT pg_catalog.setval('public.estados_servicios_id_estado_servicio_seq', 2, true);
          public          postgres    false    222            �           0    0    failed_jobs_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);
          public          postgres    false    224            �           0    0    inicios_id_inicio_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.inicios_id_inicio_seq', 394, true);
          public          postgres    false    226            �           0    0    material_status_id_ms_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('public.material_status_id_ms_seq', 3, true);
          public          postgres    false    228            �           0    0    materiales_can_id_mc_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.materiales_can_id_mc_seq', 289, true);
          public          postgres    false    231            �           0    0    materiales_id_material_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('public.materiales_id_material_seq', 127, true);
          public          postgres    false    232            �           0    0    migrations_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.migrations_id_seq', 4, true);
          public          postgres    false    234            �           0    0    parcial_mat_id_parcial_mat_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('public.parcial_mat_id_parcial_mat_seq', 252, true);
          public          postgres    false    236            �           0    0    personal_access_tokens_id_seq    SEQUENCE SET     L   SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);
          public          postgres    false    239            �           0    0    personas_id_persona_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.personas_id_persona_seq', 92, true);
          public          postgres    false    241            �           0    0    roles_id_rol_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.roles_id_rol_seq', 1, false);
          public          postgres    false    243            �           0    0    ser_mat_can_id_smc_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.ser_mat_can_id_smc_seq', 289, true);
          public          postgres    false    245            �           0    0    servicios_id_servicio_seq    SEQUENCE SET     I   SELECT pg_catalog.setval('public.servicios_id_servicio_seq', 241, true);
          public          postgres    false    247            �           0    0    tipos_presentacion_id_tp_seq    SEQUENCE SET     K   SELECT pg_catalog.setval('public.tipos_presentacion_id_tp_seq', 23, true);
          public          postgres    false    249            �           0    0    tipos_servicios_id_servicio_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('public.tipos_servicios_id_servicio_seq', 14, true);
          public          postgres    false    251            �           0    0    trimestres_id_trimestre_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('public.trimestres_id_trimestre_seq', 12, true);
          public          postgres    false    253            �           0    0    users_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.users_id_seq', 1, false);
          public          postgres    false    255            �           0    0    usuarios_id_usuario_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.usuarios_id_usuario_seq', 91, true);
          public          postgres    false    257            �           2606    99285 ,   entrega_parcial_can entrega_parcial_can_pkey 
   CONSTRAINT     n   ALTER TABLE ONLY public.entrega_parcial_can
    ADD CONSTRAINT entrega_parcial_can_pkey PRIMARY KEY (id_epc);
 V   ALTER TABLE ONLY public.entrega_parcial_can DROP CONSTRAINT entrega_parcial_can_pkey;
       public            postgres    false    215            �           2606    99287    entregas entregas_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.entregas
    ADD CONSTRAINT entregas_pkey PRIMARY KEY (id_entrega);
 @   ALTER TABLE ONLY public.entregas DROP CONSTRAINT entregas_pkey;
       public            postgres    false    217            �           2606    99289    estados estados_pkey 
   CONSTRAINT     Y   ALTER TABLE ONLY public.estados
    ADD CONSTRAINT estados_pkey PRIMARY KEY (id_estado);
 >   ALTER TABLE ONLY public.estados DROP CONSTRAINT estados_pkey;
       public            postgres    false    219            �           2606    99291 (   estados_servicios estados_servicios_pkey 
   CONSTRAINT     v   ALTER TABLE ONLY public.estados_servicios
    ADD CONSTRAINT estados_servicios_pkey PRIMARY KEY (id_estado_servicio);
 R   ALTER TABLE ONLY public.estados_servicios DROP CONSTRAINT estados_servicios_pkey;
       public            postgres    false    221            �           2606    99293    failed_jobs failed_jobs_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_pkey;
       public            postgres    false    223            �           2606    99295 #   failed_jobs failed_jobs_uuid_unique 
   CONSTRAINT     ^   ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);
 M   ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_uuid_unique;
       public            postgres    false    223            �           2606    99297    materiales id_material 
   CONSTRAINT     s   ALTER TABLE ONLY public.materiales
    ADD CONSTRAINT id_material PRIMARY KEY (id_material) INCLUDE (id_material);
 @   ALTER TABLE ONLY public.materiales DROP CONSTRAINT id_material;
       public            postgres    false    229            �           2606    99299    materiales_can id_mc 
   CONSTRAINT     e   ALTER TABLE ONLY public.materiales_can
    ADD CONSTRAINT id_mc PRIMARY KEY (id_mc) INCLUDE (id_mc);
 >   ALTER TABLE ONLY public.materiales_can DROP CONSTRAINT id_mc;
       public            postgres    false    230            �           2606    99301    servicios id_servicio 
   CONSTRAINT     r   ALTER TABLE ONLY public.servicios
    ADD CONSTRAINT id_servicio PRIMARY KEY (id_servicio) INCLUDE (id_servicio);
 ?   ALTER TABLE ONLY public.servicios DROP CONSTRAINT id_servicio;
       public            postgres    false    246            �           2606    99303    ser_mat_can id_smc 
   CONSTRAINT     e   ALTER TABLE ONLY public.ser_mat_can
    ADD CONSTRAINT id_smc PRIMARY KEY (id_smc) INCLUDE (id_smc);
 <   ALTER TABLE ONLY public.ser_mat_can DROP CONSTRAINT id_smc;
       public            postgres    false    244            �           2606    99305    tipos_presentacion id_tp 
   CONSTRAINT     i   ALTER TABLE ONLY public.tipos_presentacion
    ADD CONSTRAINT id_tp PRIMARY KEY (id_tp) INCLUDE (id_tp);
 B   ALTER TABLE ONLY public.tipos_presentacion DROP CONSTRAINT id_tp;
       public            postgres    false    248            �           2606    99307    trimestres id_trimestre 
   CONSTRAINT     v   ALTER TABLE ONLY public.trimestres
    ADD CONSTRAINT id_trimestre PRIMARY KEY (id_trimestre) INCLUDE (id_trimestre);
 A   ALTER TABLE ONLY public.trimestres DROP CONSTRAINT id_trimestre;
       public            postgres    false    252            �           2606    99309    inicios inicios_pkey 
   CONSTRAINT     Y   ALTER TABLE ONLY public.inicios
    ADD CONSTRAINT inicios_pkey PRIMARY KEY (id_inicio);
 >   ALTER TABLE ONLY public.inicios DROP CONSTRAINT inicios_pkey;
       public            postgres    false    225            �           2606    99311 $   material_status material_status_pkey 
   CONSTRAINT     e   ALTER TABLE ONLY public.material_status
    ADD CONSTRAINT material_status_pkey PRIMARY KEY (id_ms);
 N   ALTER TABLE ONLY public.material_status DROP CONSTRAINT material_status_pkey;
       public            postgres    false    227            �           2606    99313    migrations migrations_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.migrations DROP CONSTRAINT migrations_pkey;
       public            postgres    false    233            �           2606    99315    parcial_mat parcial_mat_pkey 
   CONSTRAINT     f   ALTER TABLE ONLY public.parcial_mat
    ADD CONSTRAINT parcial_mat_pkey PRIMARY KEY (id_parcial_mat);
 F   ALTER TABLE ONLY public.parcial_mat DROP CONSTRAINT parcial_mat_pkey;
       public            postgres    false    235            �           2606    99317 0   password_reset_tokens password_reset_tokens_pkey 
   CONSTRAINT     q   ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);
 Z   ALTER TABLE ONLY public.password_reset_tokens DROP CONSTRAINT password_reset_tokens_pkey;
       public            postgres    false    237            �           2606    99319 2   personal_access_tokens personal_access_tokens_pkey 
   CONSTRAINT     p   ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);
 \   ALTER TABLE ONLY public.personal_access_tokens DROP CONSTRAINT personal_access_tokens_pkey;
       public            postgres    false    238            �           2606    99321 :   personal_access_tokens personal_access_tokens_token_unique 
   CONSTRAINT     v   ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);
 d   ALTER TABLE ONLY public.personal_access_tokens DROP CONSTRAINT personal_access_tokens_token_unique;
       public            postgres    false    238            �           2606    99323    personas personas_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.personas
    ADD CONSTRAINT personas_pkey PRIMARY KEY (id_persona);
 @   ALTER TABLE ONLY public.personas DROP CONSTRAINT personas_pkey;
       public            postgres    false    240            �           2606    99325    roles roles_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id_rol);
 :   ALTER TABLE ONLY public.roles DROP CONSTRAINT roles_pkey;
       public            postgres    false    242            �           2606    99327 $   tipos_servicios tipos_servicios_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.tipos_servicios
    ADD CONSTRAINT tipos_servicios_pkey PRIMARY KEY (id_servicio) INCLUDE (id_servicio);
 N   ALTER TABLE ONLY public.tipos_servicios DROP CONSTRAINT tipos_servicios_pkey;
       public            postgres    false    250            �           2606    99329    users users_email_unique 
   CONSTRAINT     T   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);
 B   ALTER TABLE ONLY public.users DROP CONSTRAINT users_email_unique;
       public            postgres    false    254            �           2606    99331    users users_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
       public            postgres    false    254                        2606    99333    usuarios usuarios_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id_usuario);
 @   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_pkey;
       public            postgres    false    256            �           1259    99334 8   personal_access_tokens_tokenable_type_tokenable_id_index    INDEX     �   CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);
 L   DROP INDEX public.personal_access_tokens_tokenable_type_tokenable_id_index;
       public            postgres    false    238    238            	           2606    99335    servicios fk_entrega    FK CONSTRAINT     �   ALTER TABLE ONLY public.servicios
    ADD CONSTRAINT fk_entrega FOREIGN KEY (fk_entrega) REFERENCES public.entregas(id_entrega) NOT VALID;
 >   ALTER TABLE ONLY public.servicios DROP CONSTRAINT fk_entrega;
       public          postgres    false    4817    217    246                       2606    99340    parcial_mat fk_epc    FK CONSTRAINT     �   ALTER TABLE ONLY public.parcial_mat
    ADD CONSTRAINT fk_epc FOREIGN KEY (fk_epc) REFERENCES public.entrega_parcial_can(id_epc) NOT VALID;
 <   ALTER TABLE ONLY public.parcial_mat DROP CONSTRAINT fk_epc;
       public          postgres    false    215    4815    235                       2606    99345    usuarios fk_estado    FK CONSTRAINT     �   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT fk_estado FOREIGN KEY (fk_estado) REFERENCES public.estados(id_estado) NOT VALID;
 <   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT fk_estado;
       public          postgres    false    256    219    4819            
           2606    99350    servicios fk_estado_servicio    FK CONSTRAINT     �   ALTER TABLE ONLY public.servicios
    ADD CONSTRAINT fk_estado_servicio FOREIGN KEY (fk_estado_servicio) REFERENCES public.estados_servicios(id_estado_servicio) NOT VALID;
 F   ALTER TABLE ONLY public.servicios DROP CONSTRAINT fk_estado_servicio;
       public          postgres    false    246    221    4821                       2606    99355    servicios fk_incio    FK CONSTRAINT     �   ALTER TABLE ONLY public.servicios
    ADD CONSTRAINT fk_incio FOREIGN KEY (fk_inicio) REFERENCES public.inicios(id_inicio) NOT VALID;
 <   ALTER TABLE ONLY public.servicios DROP CONSTRAINT fk_incio;
       public          postgres    false    225    4827    246                       2606    99360    materiales_can fk_material    FK CONSTRAINT     �   ALTER TABLE ONLY public.materiales_can
    ADD CONSTRAINT fk_material FOREIGN KEY (fk_material) REFERENCES public.materiales(id_material) NOT VALID;
 D   ALTER TABLE ONLY public.materiales_can DROP CONSTRAINT fk_material;
       public          postgres    false    229    4831    230                       2606    99365    ser_mat_can fk_mc    FK CONSTRAINT     �   ALTER TABLE ONLY public.ser_mat_can
    ADD CONSTRAINT fk_mc FOREIGN KEY (fk_mc) REFERENCES public.materiales_can(id_mc) NOT VALID;
 ;   ALTER TABLE ONLY public.ser_mat_can DROP CONSTRAINT fk_mc;
       public          postgres    false    230    4833    244                       2606    99370    parcial_mat fk_mc    FK CONSTRAINT     �   ALTER TABLE ONLY public.parcial_mat
    ADD CONSTRAINT fk_mc FOREIGN KEY (fk_mc) REFERENCES public.materiales_can(id_mc) NOT VALID;
 ;   ALTER TABLE ONLY public.parcial_mat DROP CONSTRAINT fk_mc;
       public          postgres    false    4833    235    230                       2606    99375    materiales_can fk_ms    FK CONSTRAINT     �   ALTER TABLE ONLY public.materiales_can
    ADD CONSTRAINT fk_ms FOREIGN KEY (fk_ms) REFERENCES public.material_status(id_ms) NOT VALID;
 >   ALTER TABLE ONLY public.materiales_can DROP CONSTRAINT fk_ms;
       public          postgres    false    230    4829    227                       2606    99380    usuarios fk_persona    FK CONSTRAINT     �   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT fk_persona FOREIGN KEY (fk_persona) REFERENCES public.personas(id_persona) NOT VALID;
 =   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT fk_persona;
       public          postgres    false    240    256    4846                       2606    99385    usuarios fk_rol    FK CONSTRAINT     {   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT fk_rol FOREIGN KEY (fk_rol) REFERENCES public.roles(id_rol) NOT VALID;
 9   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT fk_rol;
       public          postgres    false    256    242    4848                       2606    99390    ser_mat_can fk_servicio    FK CONSTRAINT     �   ALTER TABLE ONLY public.ser_mat_can
    ADD CONSTRAINT fk_servicio FOREIGN KEY (fk_servicio) REFERENCES public.servicios(id_servicio) NOT VALID;
 A   ALTER TABLE ONLY public.ser_mat_can DROP CONSTRAINT fk_servicio;
       public          postgres    false    246    244    4852                       2606    99395    servicios fk_tipo_servicio    FK CONSTRAINT     �   ALTER TABLE ONLY public.servicios
    ADD CONSTRAINT fk_tipo_servicio FOREIGN KEY (fk_tipo_servicio) REFERENCES public.tipos_servicios(id_servicio) NOT VALID;
 D   ALTER TABLE ONLY public.servicios DROP CONSTRAINT fk_tipo_servicio;
       public          postgres    false    246    250    4856                       2606    99400    materiales fk_tp    FK CONSTRAINT     �   ALTER TABLE ONLY public.materiales
    ADD CONSTRAINT fk_tp FOREIGN KEY (fk_tp) REFERENCES public.tipos_presentacion(id_tp) NOT VALID;
 :   ALTER TABLE ONLY public.materiales DROP CONSTRAINT fk_tp;
       public          postgres    false    4854    248    229                       2606    99405    servicios fk_trimestre    FK CONSTRAINT     �   ALTER TABLE ONLY public.servicios
    ADD CONSTRAINT fk_trimestre FOREIGN KEY (fk_trimestre) REFERENCES public.trimestres(id_trimestre) NOT VALID;
 @   ALTER TABLE ONLY public.servicios DROP CONSTRAINT fk_trimestre;
       public          postgres    false    252    246    4858                       2606    99410    servicios fk_usuario    FK CONSTRAINT     �   ALTER TABLE ONLY public.servicios
    ADD CONSTRAINT fk_usuario FOREIGN KEY (fk_usuario) REFERENCES public.usuarios(id_usuario) NOT VALID;
 >   ALTER TABLE ONLY public.servicios DROP CONSTRAINT fk_usuario;
       public          postgres    false    256    246    4864                       2606    99415    entrega_parcial_can fk_usuario    FK CONSTRAINT     �   ALTER TABLE ONLY public.entrega_parcial_can
    ADD CONSTRAINT fk_usuario FOREIGN KEY (fk_usuario) REFERENCES public.usuarios(id_usuario) NOT VALID;
 H   ALTER TABLE ONLY public.entrega_parcial_can DROP CONSTRAINT fk_usuario;
       public          postgres    false    256    4864    215                       2606    99420    servicios fk_usuario_editor    FK CONSTRAINT     �   ALTER TABLE ONLY public.servicios
    ADD CONSTRAINT fk_usuario_editor FOREIGN KEY (fk_usuario_editor) REFERENCES public.usuarios(id_usuario) NOT VALID;
 E   ALTER TABLE ONLY public.servicios DROP CONSTRAINT fk_usuario_editor;
       public          postgres    false    246    4864    256            �   �  x��YK��8];O�T%��-{���� ���(3T�D�����9Wa.6��M�@�D/��(��(Y)S��Е�����u�|S����_�ϋR�03�U���Q�+2+�i��Qf]8ި��}�0Jm����yW7�R}�(����32F�ma���*#b�	�fV>"F���j��?�(S�t
&ρ�1J5�tډ�Z:F���f�肒�t2F�5#��]Ոe6BGG	�T/R�1Jm��[ya�|6F�YO!���L�V,Ȫ�1J�9W���:S!%�Z������V-�`f:e;�E�RIJZ��g2F���Լ���&cZOb��Q�'��J�<���%b��
�R��*DV�@MF��Q&�H`�CwN�(S3f����`�(Ӑ�f��J�(���'���Q�˘��1ʬs&�g���&c�[�e��q+Hs�(���4��F�ӑm������"�_��.C�>܆2��1~����>\_�(�W���������cޮ�&���Z�c�O�a������s$e�0P�W��C���{y��c�%��a*oa�#��2\��c��_Ӳw�hذ�ې�{����mׅ�E,y��+8�_���ܙ{J���(@�uu��!�C�#b����W�� �n������o���?o����D������{��u�Z�FĀ=���/��*��v�ߡah~�7�ߛm��Ŏ��uJ\W8�0dיVĐ��h	֮ӐFk�9��\�q�oi��<�d�=a��e(�o}(���vZ���=��W�D�i+bd�x��^�s5�Ǆ7�����7�'	��[g��n-c��$���5۰�o�$��֫��nF���0�^x��C5�R�E��iP�{�rc�v���8Ǎ9��L ��|:�>�z�a9?����NmX�C��
0���%�6x�ԍ�����($*�-&��!"X�6a��N
Ǔ{u��C�$�F���e���h���Ng�m�p�N����*������{���3�~]a|hfk��Gs��� �l>|^�'�P�I!�	<f�Y�1����cIl��I
.�[~�u'b�B-�B�܇;\R�c���_z?�g>���X���kC+�y����q�0��e��i:��a�$�|k��bä^`Dq���
�V	�Z+)�LKn�N���	
X��^l��z'p%c����8��T���GՆI��u��F;&�G++&̇��ǻ�*S5��K>�=s���=a�t�<,�kVV��0��dð]�Z�ǖe�՜I;&������g��:)�n�vY7�gM��&)���
�g�;|�I�C���u��	�&���E�5��&L�������`3�<{�0�*�x�i���j���{�d%bX�?�-���pM2pN�T����4"&�q�#��y���[,�-�2���{��x�q/�e�����S59b�jpx�Z�0�G�M�%\E������Sǫ��e����v3�z�Yp�/}�7'zM�Y�JhP=���r�$�$gI��/�����s����ߒ l��t�#1FĀ��2�A��~Vz�Q�<�kI#c�es�������f�󊼥9axQ`.��/��ԗ�g��C�2M��X�:`������I�
bΑ�_'���Q������z�\�4�듆�>I����,'M��⏜�O����$�K��^n��<���QW ܰP���h/b��G��F��?�L۬=��Nj����*�{�>�<Z5��I�'�~�x+�Ǵ���pF����8«�)��q^�2\�G?���H^��Z~Y��p+���q�ۧc�T�^���ֳy�Ȼ�^�t��]�ê����} ���>X�#lǎ�d:�L��s1V.�멡&7'���ܙ�K�8�$K��#pO���s���`e�j�bk����x���6�_@$�x}yy�?��      �      x������ � �      �      x�3�tL.�,��2���K�0c���� ^��      �      x�3�tL.�,��2���K�0c���� ^��      �      x������ � �      �   �   x�U���  ϱ��T>Ml鿎�����oD`���]�)r�jc��Yh�^�v)�嗛;�['��(ԍV8��&*�b�Xy[��ʶ��c����Cx�����(m�;�M�ȃ����A�P�,��\Z�a�pF��^VU9�s)�͗U�����S�]���H�j       �   +   x�3���Wp�+)JMOL��2�D��al��Ģ����=... ��)      �   h   x��9� @�z8�ɀ�l�'�a��A��2��%��at�� 
��a��SO�I���Kŀj42�Srрl2��g.9�������oҝm!=�� ����!�      �   3   x���  ��e�S�]�y�Ⱦ�T��h"�]v�VEY�z|����S�      �   x   x�]�A
�0E��a$�л�i�54��x}�k��_����� �9�Jm��XM��A\�e���Y�JcC+7Ϋ��������	�2�x\��.����2k��D���i�{�f@�      �      x�325�425�4�������� ��      �      x������ � �      �      x������ � �      �   O  x���Kj�0���S�)���vm��҆�u6�-�@�V�7�M�ҋuB�]���|������v�!'�{YO`��;Jw���DU%�鐵z����?D�(~��,�J8x�o���?=��<ɢ��{#]���Y��A��j�e����V�:'T�FT<ɢ���Ə9�t�=�����r\���6�Q�$����T�<Fe�2+�F�F��EQ$YԴ��A��X٫�^�v���S�c?U�]%Y�s��3�P"݀��}�p�x��D�6���	z��0[��ǃ��&Y,�pԽ�Ǩ�^$<ʠב3v��%I��a��1�.��t��Ygg����2t��,��I�      �   1   x�3�tL����,.)JL�/�2�t��L�+I�2�t��MLN������ �>      �   ,   x�3�0�42��4�0�2���421 �-�l���!�m����� �9�      �   �   x�m��m!E�P�k���`SD*x`���$Q�H�;��Gf���L�89&F�Di����#�A
��þ����}����4�F��I�mp̬xSÏ�����j�����Rd.�:����&��9��?�Dx?F��%eo�
3A_�8�<�K��a�/�fg�3	��Q~䜿 ��Be      �   7   x�3�tO����K�2�H,I�2�t/M����/I-J�2�t�O�/�ˬ����� Q�      �   K   x�3�t��KNT��/V�H-�K�KI��2�t�/*J�Q�,I�2�tO�)�M̫�/�2��/��M��q��qqq %�*      �   k   x�3�t�K-��2�tKM*��9}���L8��2s�L���|.3N�Ҽ�|.s ��-8��K�,9�SJ2Ss�ڹ8��KJ�LCN��2���Kf2����� i�#[      �      x������ � �      �   �  x�m�˒�0�5����(	v�����M�&""��@Z��{����"��*��9��"����yy�� ~$�����>RCye8l�d���!��m66��0r�͸o��_i��\�8�}��� �x��
�_f�goݍ2��e�(����hfj&�ެ\��Xkc��K�жm��MR/t����\��R��/���D^R�2�㘣�����|��{���v��kf�o�+"�l`��ɚZ�����R(&<hq'�N
 �(�Wx�2���*F�4/Jo�_Ya#�z$iHק���&�kOu��:b�L� 
�p:���蘘���@����}J��-���w������;?�h2��Pjv$X���a/��8E�v���~g�̫�+��n������ypr����:��Q�(�EK�U�(�G�`S�~4���3�֋!��_���M�YTU�os{�gO0��ەĿ��0���Z.<likS<3��~�Y܍j��QN�ŷ�]�+3k߽���K�7�8�m�k3$�(����F�8�XL_RrP5��\��	7�mOݐ��3
��ƗD6(��$�3�OO˚D���{I�<P�����5\�v� �[�9�=��~C6��'�8m3Yͯ�(v&�f���'=❌jn{p�����t�8�ݿ���O�vw��\Ǐ�/�J���XE�@�g�ʑI��:�,0V��� �e���0�8_5[P�e�ɿ{ooo =?�     