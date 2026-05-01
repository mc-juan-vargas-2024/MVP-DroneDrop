<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DroneDrop — Pide lo que quieras</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #fff7f0; color: #1a1a1a; scroll-behavior: smooth; }

        /* NAV */
        nav {
            display: flex; justify-content: space-between; align-items: center;
            padding: 1.1rem 2.5rem;
            background: white;
            border-bottom: 2px solid #ff6b00;
            box-shadow: 0 1px 8px rgba(0,0,0,.06);
            position: sticky; top: 0; z-index: 100;
            flex-wrap: wrap; gap: .75rem;
        }
        .nav-brand { font-size: 1.5rem; font-weight: 800; color: #ff6b00; letter-spacing: -0.5px; text-decoration: none; }
        .nav-brand span { color: #1a1a1a; }

        .nav-sections {
            display: flex; align-items: center; gap: .25rem;
        }
        .nav-sections a {
            padding: .45rem .95rem; border-radius: 8px;
            font-weight: 600; font-size: .85rem; text-decoration: none;
            color: #555; transition: all .2s;
        }
        .nav-sections a:hover { background: #fff0e0; color: #ff6b00; }

        .nav-links { display: flex; gap: .75rem; align-items: center; }
        .nav-links a {
            padding: .5rem 1.2rem; border-radius: 8px;
            font-weight: 600; font-size: .9rem; text-decoration: none;
            transition: all .2s;
        }
        .btn-login { color: #ff6b00; border: 2px solid #ff6b00; }
        .btn-login:hover { background: #ff6b00; color: white; }
        .btn-register { background: #ff6b00; color: white; border: 2px solid #ff6b00; }
        .btn-register:hover { background: #e55a00; border-color: #e55a00; }
        .btn-dashboard { background: #1a1a1a; color: white; border: 2px solid #1a1a1a; }
        .btn-dashboard:hover { background: #333; }

        /* HERO */
        .hero {
            max-width: 1100px; margin: 0 auto;
            padding: 5rem 2rem 4rem;
            display: flex; align-items: center; gap: 4rem;
            flex-wrap: wrap;
        }
        .hero-text { flex: 1; min-width: 280px; }
        .hero-badge {
            display: inline-block;
            background: #fff0e0; color: #ff6b00;
            font-weight: 700; font-size: .8rem; letter-spacing: .05em;
            padding: .35rem .9rem; border-radius: 50px; margin-bottom: 1.2rem;
            border: 1px solid #ffd0a0;
        }
        .hero-text h1 {
            font-size: 3.2rem; font-weight: 800; line-height: 1.15;
            margin-bottom: 1.2rem; color: #1a1a1a;
        }
        .hero-text h1 span { color: #ff6b00; }
        .hero-text p { font-size: 1.1rem; color: #555; line-height: 1.7; margin-bottom: 2rem; }
        .hero-cta { display: flex; gap: 1rem; flex-wrap: wrap; }
        .cta-primary {
            text-decoration: none; background: #ff6b00; color: white;
            font-weight: 700; padding: .85rem 2rem;
            border-radius: 10px; font-size: 1rem;
            box-shadow: 0 4px 14px rgba(255,107,0,.35); transition: all .2s;
        }
        .cta-primary:hover { background: #e55a00; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(255,107,0,.45); }
        .cta-secondary {
            text-decoration: none; background: white; color: #1a1a1a;
            font-weight: 600; padding: .85rem 2rem;
            border-radius: 10px; font-size: 1rem;
            border: 2px solid #e0e0e0; transition: all .2s;
        }
        .cta-secondary:hover { border-color: #ff6b00; color: #ff6b00; }

        /* HERO VISUAL */
        .hero-visual {
            flex: 1; max-width: 400px; min-width: 280px;
            background: white; border-radius: 20px; padding: 2rem;
            box-shadow: 0 20px 60px rgba(0,0,0,.1); border: 1px solid #ffe0c0;
        }
        .mock-product {
            display: flex; align-items: center; gap: 1rem;
            padding: .9rem; border-radius: 12px; margin-bottom: .75rem;
            background: #fff7f0; border: 1px solid #ffe5cc; transition: all .2s;
        }
        .mock-product:hover { transform: translateX(4px); }
        .mock-product:last-child { margin-bottom: 0; }
        .mock-icon {
            width: 52px; height: 52px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; flex-shrink: 0;
        }
        .mock-product-info { flex: 1; }
        .mock-product-info strong { display: block; font-size: .95rem; color: #1a1a1a; }
        .mock-product-info span { font-size: .82rem; color: #888; }
        .mock-price { font-weight: 700; color: #ff6b00; font-size: .95rem; }
        .mock-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.2rem; padding-bottom: 1rem; border-bottom: 1px solid #f0e0d0;
        }
        .mock-header strong { font-size: 1rem; color: #1a1a1a; }
        .mock-tag {
            background: #ff6b00; color: white;
            font-size: .72rem; font-weight: 700; padding: .2rem .6rem; border-radius: 50px;
        }

        /* FEATURES */
        .features { background: white; padding: 5rem 2rem; }
        .features-inner { max-width: 1100px; margin: 0 auto; }
        .section-title { text-align: center; margin-bottom: 3.5rem; }
        .section-title h2 { font-size: 2.1rem; font-weight: 800; color: #1a1a1a; }
        .section-title p { color: #666; margin-top: .6rem; font-size: 1rem; }
        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; }
        .feature-card {
            padding: 2rem; border-radius: 16px; border: 1px solid #f0e0d0;
            background: #fff7f0; transition: all .25s;
        }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(255,107,0,.12); border-color: #ff6b00; }
        .feature-icon { font-size: 2.2rem; margin-bottom: 1rem; }
        .feature-card h3 { font-size: 1.05rem; font-weight: 700; margin-bottom: .5rem; color: #1a1a1a; }
        .feature-card p { font-size: .9rem; color: #666; line-height: 1.6; }

        /* DRONE CARD — Diferenciador */
        .feature-card--drone {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            border: 2px solid #ff6b00;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 0 0 0 rgba(255,107,0,0);
            animation: droneBorderPulse 3s ease-in-out infinite;
        }
        .feature-card--drone::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(circle at 20% 50%, rgba(255,107,0,.15) 0%, transparent 65%);
            pointer-events: none;
        }
        .feature-card--drone h3 { color: #fff; font-size: 1.1rem; display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; }
        .feature-card--drone p { color: #ccc; }
        .feature-card--drone p strong { color: #ff9a40; }
        .feature-card--drone:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(255,107,0,.35) !important;
            border-color: #ff9a40;
        }
        .badge-new {
            display: inline-block;
            background: #ff6b00; color: white;
            font-size: .65rem; font-weight: 800; letter-spacing: .05em;
            padding: .2rem .55rem; border-radius: 50px;
            vertical-align: middle;
            animation: badgePop .5s ease;
        }
        @keyframes badgePop {
            0% { transform: scale(0); opacity: 0; }
            80% { transform: scale(1.15); }
            100% { transform: scale(1); opacity: 1; }
        }
        @keyframes droneBorderPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(255,107,0,0), 0 8px 30px rgba(255,107,0,.08); }
            50% { box-shadow: 0 0 20px 4px rgba(255,107,0,.25), 0 8px 30px rgba(255,107,0,.2); }
        }
        .drone-pulse {
            animation: droneHover 2s ease-in-out infinite;
            display: inline-block;
        }
        @keyframes droneHover {
            0%, 100% { transform: translateY(0px) rotate(-5deg); }
            50% { transform: translateY(-6px) rotate(5deg); }
        }

        /* ABOUT US */
        .about { background: linear-gradient(135deg, #fff7f0 0%, #ffe8d0 100%); padding: 5rem 2rem; }
        .about-inner { max-width: 1100px; margin: 0 auto; }
        .org-description {
            max-width: 760px; margin: 0 auto 3rem;
            background: white; border-radius: 20px; padding: 2.5rem;
            border: 1px solid #ffe0c0; box-shadow: 0 8px 30px rgba(255,107,0,.08);
            text-align: center;
        }
        .org-description p {
            font-size: 1rem; color: #555; line-height: 1.8;
        }
        .org-description p + p { margin-top: 1rem; }
        .team-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-top: 1rem; }
        .team-card {
            background: white; border-radius: 20px; padding: 2.5rem 2rem;
            border: 1px solid #ffe0c0; text-align: center;
            box-shadow: 0 8px 30px rgba(255,107,0,.08);
            transition: all .3s;
        }
        .team-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(255,107,0,.18); border-color: #ff6b00; }
        .team-avatar {
            width: 90px; height: 90px; border-radius: 50%;
            background: linear-gradient(135deg, #ff6b00, #ff9a40);
            display: flex; align-items: center; justify-content: center;
            font-size: 2.2rem; margin: 0 auto 1.2rem;
            box-shadow: 0 6px 20px rgba(255,107,0,.3);
        }
        .team-card h3 { font-size: 1.15rem; font-weight: 800; color: #1a1a1a; margin-bottom: .4rem; }
        .team-role {
            display: inline-block;
            background: #fff0e0; color: #ff6b00;
            font-size: .78rem; font-weight: 700; letter-spacing: .04em;
            padding: .3rem .9rem; border-radius: 50px; margin-bottom: .9rem;
            border: 1px solid #ffd0a0;
        }
        .team-card p { font-size: .88rem; color: #777; line-height: 1.6; }
        .unab-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            background: white; border: 1px solid #ffe0c0;
            border-radius: 50px; padding: .5rem 1.2rem;
            font-size: .82rem; font-weight: 600; color: #555;
            margin-bottom: 2.5rem; box-shadow: 0 2px 8px rgba(0,0,0,.06);
        }

        /* CONTACT */
        .contact { background: white; padding: 5rem 2rem; }
        .contact-inner { max-width: 900px; margin: 0 auto; }
        .contact-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.5rem; margin-top: 1rem;
        }
        .contact-card {
            background: #fff7f0; border-radius: 18px; padding: 2rem;
            border: 1px solid #ffe0c0; transition: all .25s; text-align: center;
        }
        .contact-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(255,107,0,.12); border-color: #ff6b00; }
        .contact-icon {
            width: 64px; height: 64px; border-radius: 16px;
            background: linear-gradient(135deg, #ff6b00, #ff9a40);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; margin: 0 auto 1.2rem;
            box-shadow: 0 4px 16px rgba(255,107,0,.3);
        }
        .contact-card h3 { font-size: 1rem; font-weight: 800; color: #1a1a1a; margin-bottom: .6rem; }
        .contact-card a {
            display: block; color: #ff6b00; font-weight: 600;
            font-size: .9rem; text-decoration: none; transition: color .2s;
            margin-bottom: .3rem;
        }
        .contact-card a:hover { color: #e55a00; text-decoration: underline; }
        .contact-card span { font-size: .85rem; color: #888; }
        .contact-cta {
            margin-top: 3rem; text-align: center;
            background: linear-gradient(135deg, #ff6b00, #ff9a40);
            border-radius: 20px; padding: 3rem 2rem;
            color: white;
        }
        .contact-cta h3 { font-size: 1.6rem; font-weight: 800; margin-bottom: .75rem; }
        .contact-cta p { font-size: 1rem; opacity: .9; }

        /* FOOTER */
        footer { padding: 2rem; text-align: center; color: #999; font-size: .85rem; background: #1a1a1a; border-top: 1px solid #333; }
        footer strong { color: #ff6b00; }
        footer p { margin-bottom: .4rem; }
        footer a { color: #ff9a40; text-decoration: none; }
        footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <nav id="inicio">
        <a href="#inicio" class="nav-brand">Drone<span>Drop</span></a>

        <div class="nav-sections">
            <a href="#inicio">Inicio</a>
            <a href="#funcionalidades">Funcionalidades</a>
            <a href="#nosotros">Nosotros</a>
            <a href="#contacto">Contáctanos</a>
        </div>

        @if (Route::has('login'))
            <div class="nav-links">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-dashboard">Mi Panel</a>
                @else
                    <a href="{{ route('login') }}" class="btn-login">Iniciar Sesión</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-register">Registrarse</a>
                    @endif
                @endauth
            </div>
        @endif
    </nav>

    <!-- HERO -->
    <section style="background: linear-gradient(135deg, #fff7f0 0%, #ffe8d0 100%);">
        <div class="hero">
            <div class="hero-text">
                <div class="hero-badge">🚀 Tu app de domicilios en Bucaramanga</div>
                <h1>Pide lo que quieras, <span>cuando quieras</span></h1>
                <p>Conectamos clientes, comercios y repartidores en una sola plataforma. Rápido, seguro y fácil de usar.</p>
                <div class="hero-cta">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="cta-primary">Ir a mi panel →</a>
                    @else
                        <a href="{{ route('register') }}" class="cta-primary">Empieza gratis →</a>
                        <a href="{{ route('login') }}" class="cta-secondary">Ya tengo cuenta</a>
                    @endauth
                </div>
            </div>
            <div class="hero-visual">
                <div class="mock-header">
                    <strong>🔥 Ofertas de hoy</strong>
                    <span class="mock-tag">Bucaramanga</span>
                </div>
                <div class="mock-product">
                    <div class="mock-icon" style="background:#fff0e0;">🍕</div>
                    <div class="mock-product-info">
                        <strong>Pizza Pepperoni</strong>
                        <span>Desde $20.000 · Juan Chaparro</span>
                    </div>
                    <span class="mock-price">⭐ 4.9</span>
                </div>
                <div class="mock-product">
                    <div class="mock-icon" style="background:#e8f5e9;">🍔</div>
                    <div class="mock-product-info">
                        <strong>Hamburguesa Angus</strong>
                        <span>Desde $30.000 · BurgerHouse</span>
                    </div>
                    <span class="mock-price">⭐ 4.8</span>
                </div>
                <div class="mock-product">
                    <div class="mock-icon" style="background:#e3f2fd;">🍦</div>
                    <div class="mock-product-info">
                        <strong>Helado Chocolate</strong>
                        <span>Desde $5.000 · Creamería</span>
                    </div>
                    <span class="mock-price">⭐ 4.7</span>
                </div>
                <div style="margin-top:1rem; padding:.8rem; background:#fff0e0; border-radius:10px; text-align:center; border:1px dashed #ffb366;">
                    <span style="font-size:.82rem; color:#cc4400; font-weight:700;">🚚 Domicilio GRATIS en tu primer pedido</span>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="features" id="funcionalidades">
        <div class="features-inner">
            <div class="section-title">
                <h2>Todo en un solo lugar</h2>
                <p>Una plataforma diseñada para clientes, comercios y repartidores</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🛍️</div>
                    <h3>Explora comercios</h3>
                    <p>Descubre restaurantes y tiendas locales en Bucaramanga con catálogos completos y precios actualizados.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3>Pedidos rápidos</h3>
                    <p>Agrega productos al carrito, paga de forma segura y sigue el estado de tu pedido en tiempo real.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🗺️</div>
                    <h3>Seguimiento en mapa</h3>
                    <p>Visualiza la zona de cobertura y el estado de entrega directamente desde tu panel de pedidos.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🏪</div>
                    <h3>Gestiona tu comercio</h3>
                    <p>Si eres comerciante, administra tu catálogo, sube fotos de tus productos y controla los pedidos entrantes.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🛵</div>
                    <h3>Panel de repartidor</h3>
                    <p>Los repartidores pueden ver entregas disponibles, aceptarlas y gestionar su historial desde un panel dedicado.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔐</div>
                    <h3>Seguro y confiable</h3>
                    <p>Registro por roles (cliente, comercio, repartidor) con autenticación segura y control de acceso.</p>
                </div>

                <!-- NUEVA FILA — diferenciador drone + 2 extras -->
                <div class="feature-card feature-card--drone">
                    <div class="feature-icon drone-pulse">🚁</div>
                    <h3>Entregas con Dron <span class="badge-new">⚡ Diferenciador</span></h3>
                    <p>Nuestra tecnología de entrega por dron reduce los tiempos a la mitad. Vuelos autónomos, rastreo en tiempo real y llegada directa a tu puerta. <strong>El futuro de los domicilios ya está aquí.</strong></p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔔</div>
                    <h3>Notificaciones en tiempo real</h3>
                    <p>Recibe alertas instantáneas en cada etapa de tu pedido: confirmación, preparación, despacho y entrega. Siempre informado, sin sorpresas.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⭐</div>
                    <h3>Reseñas y calificaciones</h3>
                    <p>Califica tu experiencia, deja reseñas de los comercios y ayuda a la comunidad a elegir las mejores opciones de Bucaramanga.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SOBRE NOSOTROS -->
    <section class="about" id="nosotros">
        <div class="about-inner">
            <div class="section-title">
                <h2>Sobre Nosotros</h2>
                <p>Conoce al equipo detrás de DroneDrop</p>
            </div>
            <div style="text-align:center;">
                <span class="unab-badge">🎓 Estudiantes de Ingeniería de Sistemas — <strong>UNAB · Bucaramanga</strong></span>
            </div>

            <!-- Descripción de la organización -->
            <div class="org-description">
                <p>
                    <strong>DroneDrop</strong> es una iniciativa académica nacida en las aulas de la
                    <strong>Universidad Autónoma de Bucaramanga (UNAB)</strong>, desarrollada por estudiantes
                    de <strong>Ingeniería de Sistemas</strong> con el objetivo de aplicar tecnología real
                    para resolver necesidades cotidianas de nuestra ciudad.
                </p>
                <p>
                    Nuestro propósito es democratizar el acceso a los domicilios locales, conectando de manera
                    eficiente a clientes, comercios y repartidores en una sola plataforma digital. Creemos en el
                    emprendimiento estudiantil, la innovación tecnológica y el impacto social positivo desde el campus.
                </p>
                <p>
                    🏆 Somos un equipo comprometido con la excelencia técnica, el trabajo en equipo y el aprendizaje
                    continuo. DroneDrop no es solo un proyecto universitario — <em>es nuestra visión del futuro del
                    comercio local en Colombia</em>.
                </p>
            </div>

            <div class="team-grid">
                <div class="team-card">
                    <div class="team-avatar">👨‍💻</div>
                    <h3>Juan Jose Vargas</h3>
                    <span class="team-role">⚙️ Desarrollador Full-Stack</span>
                    <p>Apasionado por construir experiencias digitales. Responsable del backend y la lógica de negocio de DroneDrop.</p>
                </div>
                <div class="team-card">
                    <div class="team-avatar">🎨</div>
                    <h3>Juan Diego Chaparro</h3>
                    <span class="team-role">🖌️ Diseño &amp; Frontend</span>
                    <p>Encargado de la interfaz de usuario y la experiencia visual. Transforma ideas en interfaces limpias y modernas.</p>
                </div>
                <div class="team-card">
                    <div class="team-avatar">🚀</div>
                    <h3>Santiago Amado</h3>
                    <span class="team-role">📦 Logística &amp; Operaciones</span>
                    <p>Responsable del módulo de repartidores y la lógica de domicilios. Garantiza que cada pedido llegue a tiempo.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTÁCTANOS -->
    <section class="contact" id="contacto">
        <div class="contact-inner">
            <div class="section-title">
                <h2>Contáctanos</h2>
                <p>Estamos disponibles para resolver tus dudas o escuchar tus ideas</p>
            </div>

            <div class="contact-grid">
                <div class="contact-card">
                    <div class="contact-icon">📞</div>
                    <h3>Teléfono / WhatsApp</h3>
                    <a href="tel:+573167232440">+57 316 723 2440</a>
                    <span>Lun – Vie · 8 am – 6 pm</span>
                </div>
                <div class="contact-card">
                    <div class="contact-icon">✉️</div>
                    <h3>Correos del equipo</h3>
                    <a href="mailto:jvargas156@unab.edu.co">jvargas156@unab.edu.co</a>
                    <a href="mailto:jnino195@unab.edu.co">jnino195@unab.edu.co</a>
                    <a href="mailto:jchaparro167@unab.edu.co">jchaparro167@unab.edu.co</a>
                </div>
                <div class="contact-card">
                    <div class="contact-icon">📍</div>
                    <h3>Ubicación</h3>
                    <a href="https://maps.google.com/?q=UNAB+Bucaramanga" target="_blank" rel="noopener">UNAB · Bucaramanga</a>
                    <span>Santander, Colombia</span>
                </div>
            </div>

            <div class="contact-cta">
                <h3>¿Tienes un comercio o quieres ser repartidor?</h3>
                <p>Regístrate gratis y empieza a recibir pedidos en minutos. ¡La plataforma más ágil de Bucaramanga te espera!</p>
            </div>
        </div>
    </section>

    <footer>
        <p>© {{ date('Y') }} <strong>DroneDrop</strong> · Bucaramanga, Colombia · Todos los derechos reservados.</p>
        <p>
            <a href="mailto:jvargas156@unab.edu.co">jvargas156@unab.edu.co</a> ·
            <a href="mailto:jnino195@unab.edu.co">jnino195@unab.edu.co</a> ·
            <a href="mailto:jchaparro167@unab.edu.co">jchaparro167@unab.edu.co</a>
        </p>
        <p style="margin-top:.4rem;">📞 <a href="tel:+573167232440">+57 316 723 2440</a> · 🎓 Estudiantes de Ingeniería de Sistemas — UNAB</p>
    </footer>

</body>
</html>
