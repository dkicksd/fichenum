<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FicheNum transforme tout contenu en fiches interactives ultra-condensées. Générez des fiches pédagogiques avec texte, infographie, audio et quiz en 30 secondes.">
    <meta name="keywords" content="fiche interactive, générateur de fiches, résumé automatique, outil pédagogique, création de contenu, IA éducative, synthèse de contenu">
    <meta name="author" content="FicheNum">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Réseaux sociaux -->
    <meta property="og:title" content="FicheNum - Générateur d'Ultra-Fiches Interactives">
    <meta property="og:description" content="Transformez n'importe quel contenu en fiche interactive ultra-condensée en moins de 30 secondes.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://fichenum.com">
    <meta property="og:image" content="https://fichenum.com/images/og-image.jpg">
    
    <!-- Schema.org pour Google -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SoftwareApplication",
      "name": "FicheNum",
      "description": "Générateur d'Ultra-Fiches Interactives utilisant l'IA pour créer des résumés pédagogiques multimédia",
      "applicationCategory": "EducationalApplication",
      "operatingSystem": "Web",
      "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "EUR",
        "availability": "https://schema.org/InStock"
      },
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.8",
        "ratingCount": "157",
        "bestRating": "5"
      }
    }
    </script>
    
    <title>FicheNum - Générateur d'Ultra-Fiches Interactives | IA Pédagogique</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            overflow-x: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        /* Particles d'arrière-plan */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Header futuriste */
        .futuristic-header {
            background: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 2rem;
            font-weight: bold;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { filter: drop-shadow(0 0 5px rgba(255, 107, 107, 0.5)); }
            to { filter: drop-shadow(0 0 15px rgba(78, 205, 196, 0.5)); }
        }

        /* Section héro avec effet morphing */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .morphing-blob {
            position: absolute;
            top: 50%;
            right: 10%;
            width: 300px;
            height: 300px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1);
            border-radius: 50% 40% 60% 30%;
            animation: morph 8s ease-in-out infinite;
            opacity: 0.7;
            filter: blur(1px);
        }

        @keyframes morph {
            0%, 100% { border-radius: 50% 40% 60% 30%; transform: translate(0, -50%) rotate(0deg); }
            25% { border-radius: 40% 60% 30% 50%; transform: translate(-20px, -60%) rotate(90deg); }
            50% { border-radius: 60% 30% 50% 40%; transform: translate(20px, -40%) rotate(180deg); }
            75% { border-radius: 30% 50% 40% 60%; transform: translate(-10px, -55%) rotate(270deg); }
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 900;
            color: white;
            text-shadow: 2px 2px 20px rgba(0, 0, 0, 0.5);
            animation: slideInLeft 1s ease-out;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            margin: 2rem 0;
            animation: slideInLeft 1s ease-out 0.3s both;
        }

        @keyframes slideInLeft {
            from { transform: translateX(-100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Input magique */
        .magic-input-container {
            position: relative;
            margin: 3rem 0;
            animation: slideInUp 1s ease-out 0.6s both;
        }

        .magic-input {
            width: 100%;
            padding: 20px 60px 20px 20px;
            border: none;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            font-size: 1.1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .magic-input:focus {
            outline: none;
            transform: scale(1.02);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .magic-button {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }

        .magic-button:hover {
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 5px 20px rgba(255, 107, 107, 0.5);
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(255, 107, 107, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(255, 107, 107, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 107, 107, 0); }
        }

        @keyframes slideInUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Types de contenu avec hover 3D */
        .content-types {
            display: flex;
            gap: 1rem;
            margin: 2rem 0;
            animation: slideInUp 1s ease-out 0.9s both;
        }

        .content-type {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 1rem;
            text-align: center;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            transform-style: preserve-3d;
        }

        .content-type:hover {
            transform: translateY(-10px) rotateX(10deg);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .content-type i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        /* Section fonctionnalités avec cartes flottantes */
        .features-section {
            background: rgba(0, 0, 0, 0.05);
            backdrop-filter: blur(20px);
            padding: 5rem 0;
            margin: 5rem 0;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 2rem;
            margin: 1rem 0;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .feature-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 2rem;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        /* Timeline de création */
        .timeline {
            position: relative;
            max-width: 800px;
            margin: 3rem auto;
        }

        .timeline::after {
            content: '';
            position: absolute;
            width: 4px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -2px;
            border-radius: 2px;
        }

        .timeline-item {
            padding: 10px 40px;
            position: relative;
            background-color: inherit;
            width: 50%;
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            right: -10px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            border-radius: 50%;
            top: 25px;
            z-index: 1;
            animation: pulse 2s infinite;
        }

        .timeline-item:nth-child(even) {
            left: 50%;
        }

        .timeline-item:nth-child(even)::after {
            left: -10px;
        }

        .timeline-content {
            padding: 20px 30px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* CTA Section avec effet néon */
        .cta-section {
            background: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(20px);
            padding: 5rem 0;
            text-align: center;
        }

        .neon-button {
            display: inline-block;
            padding: 15px 40px;
            background: transparent;
            border: 2px solid #ff6b6b;
            border-radius: 50px;
            color: #ff6b6b;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .neon-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 107, 107, 0.2), transparent);
            transition: left 0.5s;
        }

        .neon-button:hover::before {
            left: 100%;
        }

        .neon-button:hover {
            color: white;
            background: #ff6b6b;
            box-shadow: 0 0 20px #ff6b6b, 0 0 40px #ff6b6b;
            transform: scale(1.05);
        }

        /* Fenêtre de résultat */
        .result-window {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.8);
            width: 90%;
            max-width: 700px;
            background: linear-gradient(135deg, #2c3e50, #4a6491);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .result-window.active {
            opacity: 1;
            visibility: visible;
            transform: translate(-50%, -50%) scale(1);
        }

        .result-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .result-title {
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
        }

        .close-result {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            transition: color 0.3s;
        }

        .close-result:hover {
            color: #ff6b6b;
        }

        .result-content {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .result-features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .result-feature {
            display: flex;
            align-items: center;
            color: white;
        }

        .result-feature i {
            margin-right: 10px;
            font-size: 1.2rem;
            color: #4ecdc4;
        }

        .share-container {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .share-link {
            flex-grow: 1;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 50px;
            padding: 12px 20px;
            color: #333;
            font-size: 0.9rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .copy-button {
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            border: none;
            border-radius: 50px;
            color: white;
            padding: 12px 25px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .copy-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .copy-button.copied {
            background: linear-gradient(45deg, #4ecdc4, #96c93d);
        }

        .copy-button.copied::after {
            content: '✓ Copié !';
        }

        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Toast */
        .toast {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            z-index: 3000;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        
        /* Section sémantique */
        .semantic-section {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem;
            margin: 3rem auto;
            max-width: 1200px;
            color: white;
        }
        
        .semantic-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .semantic-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .semantic-card:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-5px);
        }
        
        .semantic-card h3 {
            color: #4ecdc4;
            margin-bottom: 1rem;
        }
        
        /* Footer */
        .footer {
            background: rgba(0, 0, 0, 0.2);
            padding: 3rem 0;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .footer h5 {
            color: white;
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .footer h5::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 2px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.8rem;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer-links a:hover {
            color: white;
            padding-left: 5px;
        }
        
        .copyright {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title { font-size: 2.5rem; }
            .morphing-blob { width: 200px; height: 200px; }
            .content-types { flex-wrap: wrap; }
            .timeline::after { left: 31px; }
            .timeline-item { width: 100%; padding-left: 70px; padding-right: 25px; }
            .timeline-item::after { left: 21px; }
            .timeline-item:nth-child(even) { left: 0%; }
            .result-features { grid-template-columns: 1fr; }
            .share-container { flex-direction: column; }
            .semantic-section { padding: 1.5rem; }
        }
    </style>
</head>
<body>
    <!-- Particules d'arrière-plan -->
    <div class="particles" id="particles"></div>

    <!-- Overlay pour la fenêtre de résultat -->
    <div class="overlay" id="overlay"></div>

    <!-- Toast pour la notification de copie -->
    <div class="toast" id="toast">Lien copié dans le presse-papiers !</div>

    <!-- Fenêtre de résultat -->
    <div class="result-window" id="resultWindow">
        <div class="result-header">
            <h3 class="result-title">Votre fiche est prête !</h3>
            <button class="close-result" id="closeResult">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="result-content">
            <p>Votre fiche interactive a été générée avec succès ! Voici un aperçu des éléments inclus :</p>
            
            <div class="result-features">
                <div class="result-feature">
                    <i class="fas fa-check-circle"></i> Texte synthétisé
                </div>
                <div class="result-feature">
                    <i class="fas fa-check-circle"></i> Infographie
                </div>
                <div class="result-feature">
                    <i class="fas fa-check-circle"></i> Audio explicatif
                </div>
                <div class="result-feature">
                    <i class="fas fa-check-circle"></i> Quiz interactif
                </div>
                <div class="result-feature">
                    <i class="fas fa-check-circle"></i> QR-code
                </div>
                <div class="result-feature">
                    <i class="fas fa-check-circle"></i> Partage en un clic
                </div>
            </div>
            
            <p>Vous pouvez maintenant partager cette fiche avec vos collègues ou étudiants.</p>
        </div>
        
        <div class="share-container">
            <div class="share-link" id="shareLink">
                https://fichenum.com/fiche/12345
            </div>
            <button class="copy-button" id="copyButton">
                <i class="fas fa-copy"></i> Copier le lien
            </button>
        </div>
    </div>

    <!-- Header futuriste -->
    <nav class="navbar navbar-expand-lg futuristic-header">
        <div class="container">
            <a class="navbar-brand logo" href="#">FicheNum</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-white">
                    <li class="nav-item"><a class="nav-link text-white" href="#features">Fonctionnalités</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#how-it-works">Comment ça marche</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#use-cases">Cas d'usage</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#pricing">Tarifs</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Section Héro -->
    <section class="hero-section">
        <div class="morphing-blob"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="hero-title">Ultra-Fiches<br><span style="color: #4ecdc4;">Interactives</span></h1>
                    <p class="hero-subtitle">
                        Transformez n'importe quel contenu en fiche interactive ultra-condensée en moins de 30 secondes. 
                        Lien, PDF, photo, ou simple question - FicheGPT fait le reste !
                    </p>
                    
                    <!-- Input magique -->
                    <div class="magic-input-container">
                        <input type="text" class="magic-input" placeholder="Collez un lien, uploadez un PDF, ou tapez 'Explique-moi le bitcoin'..." id="magicInput">
                        <button class="magic-button" onclick="generateFiche()">
                            <i class="fas fa-magic"></i>
                        </button>
                    </div>

                    <!-- Types de contenu -->
                    <div class="content-types">
                        <div class="content-type" onclick="setInputType('link')">
                            <i class="fas fa-link"></i>
                            <div>Lien Web</div>
                        </div>
                        <div class="content-type" onclick="setInputType('pdf')">
                            <i class="fas fa-file-pdf"></i>
                            <div>PDF</div>
                        </div>
                        <div class="content-type" onclick="setInputType('image')">
                            <i class="fas fa-image"></i>
                            <div>Image</div>
                        </div>
                        <div class="content-type" onclick="setInputType('question')">
                            <i class="fas fa-question-circle"></i>
                            <div>Question</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Fonctionnalités -->
    <section id="features" class="features-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-4 text-white fw-bold">Pourquoi FicheNum ?</h2>
                <p class="lead text-white">L'IA qui révolutionne votre façon d'apprendre</p>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h4 class="text-center mb-3">Ultra-Rapide</h4>
                        <p class="text-center">Moins de 30 secondes pour transformer n'importe quel contenu en fiche interactive complète.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h4 class="text-center mb-3">IA Maison</h4>
                        <p class="text-center">FicheGPT, notre IA propriétaire, analyse et synthétise avec une précision chirurgicale.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-share-alt"></i>
                        </div>
                        <h4 class="text-center mb-3">Partage Universel</h4>
                        <p class="text-center">QR-code automatique pour partager vos fiches partout, sur tous les supports.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline Comment ça marche -->
    <section id="how-it-works" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-4 text-white fw-bold">Comment ça marche ?</h2>
                <p class="lead text-white">4 étapes, 30 secondes, résultat magique</p>
            </div>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-content">
                        <h5><i class="fas fa-upload text-primary"></i> 1. Vous balancez</h5>
                        <p>Lien, PDF, image, ou simple question - tout est bon pour FicheNum !</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <h5><i class="fas fa-cogs text-success"></i> 2. FicheGPT analyse</h5>
                        <p>Notre IA maison décortique, analyse et identifie les points clés essentiels.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <h5><i class="fas fa-magic text-warning"></i> 3. Génération magique</h5>
                        <p>Création automatique : texte + infographie + audio + quiz interactif.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <h5><i class="fas fa-rocket text-danger"></i> 4. Partage instantané</h5>
                        <p>QR-code généré, lien de partage prêt - votre fiche est live !</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Section sémantique -->
    <section id="use-cases" class="semantic-section">
        <div class="container">
            <h2 class="text-center mb-5">FicheNum : Votre outil pédagogique ultime</h2>
            
            <div class="semantic-grid">
                <div class="semantic-card">
                    <h3><i class="fas fa-graduation-cap me-2"></i> Pour les étudiants</h3>
                    <p>Transformez vos cours et manuels en fiches de révision interactives. Gagnez du temps sur vos études avec des résumés clairs et des quiz d'auto-évaluation.</p>
                </div>
                
                <div class="semantic-card">
                    <h3><i class="fas fa-chalkboard-teacher me-2"></i> Pour les enseignants</h3>
                    <p>Créez des supports pédagogiques attrayants en quelques secondes. FichesNum facilite la création de contenus pour tous les niveaux d'apprentissage.</p>
                </div>
                
                <div class="semantic-card">
                    <h3><i class="fas fa-briefcase me-2"></i> Pour les professionnels</h3>
                    <p>Transformez vos rapports, présentations et documents complexes en fiches mémo partageables. Idéal pour les formations et le partage de connaissances.</p>
                </div>
                
                <div class="semantic-card">
                    <h3><i class="fas fa-book-reader me-2"></i> Pour les autodidactes</h3>
                    <p>Consolidez vos apprentissages en ligne avec des fiches interactives personnalisées. Transformez n'importe quelle ressource web en matériel d'étude efficace.</p>
                </div>
            </div>
            
            <div class="mt-5">
                <h3 class="text-center mb-4">Notre technologie</h3>
                <p class="text-center">FicheNum utilise une combinaison d'IA avancée pour transformer le contenu :</p>
                <ul class="text-center mt-3" style="list-style: none; padding: 0;">
                    <li class="mb-2"><i class="fas fa-robot me-2"></i> NLP (Natural Language Processing) pour l'analyse sémantique</li>
                    <li class="mb-2"><i class="fas fa-chart-pie me-2"></i> Génération automatique d'infographies</li>
                    <li class="mb-2"><i class="fas fa-microphone-alt me-2"></i> Synthèse vocale pour les résumés audio</li>
                    <li class="mb-2"><i class="fas fa-brain me-2"></i> Modèles d'apprentissage profond pour l'extraction de connaissances</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="display-4 text-white fw-bold mb-4">Prêt à révolutionner votre apprentissage ?</h2>
            <p class="lead text-white mb-4">Rejoignez les milliers d'utilisateurs qui ont déjà adopté FicheNum</p>
            <a href="#" class="neon-button">Commencer gratuitement</a>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>FicheNum</h5>
                    <p>L'outil ultime pour transformer tout contenu en fiches pédagogiques interactives en quelques secondes.</p>
                </div>
                
                <div class="col-md-2 mb-4">
                    <h5>Navigation</h5>
                    <ul class="footer-links">
                        <li><a href="#">Accueil</a></li>
                        <li><a href="#features">Fonctionnalités</a></li>
                        <li><a href="#how-it-works">Comment ça marche</a></li>
                        <li><a href="#use-cases">Cas d'usage</a></li>
                    </ul>
                </div>
                
                <div class="col-md-3 mb-4">
                    <h5>Légal</h5>
                    <ul class="footer-links">
                        <li><a href="#">Conditions d'utilisation</a></li>
                        <li><a href="#">Politique de confidentialité</a></li>
                        <li><a href="#">Mentions légales</a></li>
                    </ul>
                </div>
                
                <div class="col-md-3 mb-4">
                    <h5>Contact</h5>
                    <ul class="footer-links">
                        <li><a href="mailto:contact@fichenum.com"><i class="fas fa-envelope me-2"></i> contact@fichenum.com</a></li>
                        <li><a href="#"><i class="fas fa-map-marker-alt me-2"></i> Paris, France</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2023 FicheNum. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Génération des particules
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.width = Math.random() * 10 + 5 + 'px';
                particle.style.height = particle.style.width;
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 6 + 's';
                particle.style.animationDuration = (Math.random() * 3 + 3) + 's';
                particlesContainer.appendChild(particle);
            }
        }

        // Types d'input
        function setInputType(type) {
            const input = document.getElementById('magicInput');
            const placeholders = {
                'link': 'Collez votre lien ici (YouTube, article, site web...)',
                'pdf': 'Uploadez votre PDF ou collez un lien vers le document',
                'image': 'Uploadez votre image ou collez un lien vers l\'image',
                'question': 'Posez votre question (ex: "Explique-moi la blockchain")'
            };
            input.placeholder = placeholders[type];
            input.focus();
        }

        // Génération de fiche
        function generateFiche() {
            const input = document.getElementById('magicInput');
            const button = document.querySelector('.magic-button');
            
            if (!input.value.trim()) {
                input.style.border = '2px solid #ff6b6b';
                setTimeout(() => input.style.border = 'none', 1000);
                return;
            }

            // Animation de chargement
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.style.background = 'linear-gradient(45deg, #45b7d1, #96c93d)';
            
            setTimeout(() => {
                button.innerHTML = '<i class="fas fa-check"></i>';
                button.style.background = 'linear-gradient(45deg, #96c93d, #45b7d1)';
                
                // Simulation de génération de fiche
                setTimeout(() => {
                    // Générer un lien unique pour cette fiche
                    const randomId = Math.random().toString(36).substring(2, 10);
                    const shareLink = `https://fichenum.com/fiche/${randomId}`;
                    document.getElementById('shareLink').textContent = shareLink;
                    
                    // Afficher la fenêtre de résultat
                    showResultWindow();
                    
                    // Reset
                    setTimeout(() => {
                        button.innerHTML = '<i class="fas fa-magic"></i>';
                        button.style.background = 'linear-gradient(45deg, #ff6b6b, #4ecdc4)';
                        input.value = '';
                    }, 500);
                }, 1000);
            }, 2000);
        }

        // Afficher la fenêtre de résultat
        function showResultWindow() {
            const overlay = document.getElementById('overlay');
            const resultWindow = document.getElementById('resultWindow');
            
            overlay.classList.add('active');
            resultWindow.classList.add('active');
        }

        // Fermer la fenêtre de résultat
        function closeResultWindow() {
            const overlay = document.getElementById('overlay');
            const resultWindow = document.getElementById('resultWindow');
            
            overlay.classList.remove('active');
            resultWindow.classList.remove('active');
        }

        // Copier le lien dans le presse-papiers
        function copyToClipboard() {
            const copyButton = document.getElementById('copyButton');
            const shareLink = document.getElementById('shareLink');
            const toast = document.getElementById('toast');
            
            // Copier le texte du lien
            navigator.clipboard.writeText(shareLink.textContent)
                .then(() => {
                    // Animation de confirmation
                    copyButton.classList.add('copied');
                    
                    // Afficher le toast
                    toast.classList.add('show');
                    setTimeout(() => {
                        toast.classList.remove('show');
                    }, 3000);
                    
                    // Reset après 3 secondes
                    setTimeout(() => {
                        copyButton.classList.remove('copied');
                        copyButton.innerHTML = '<i class="fas fa-copy"></i> Copier le lien';
                    }, 3000);
                })
                .catch(err => {
                    console.error('Erreur lors de la copie: ', err);
                    alert('Impossible de copier le lien. Veuillez le copier manuellement.');
                });
        }

        // Animation au scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('.feature-card, .timeline-item, .semantic-card');
            elements.forEach(el => {
                const elementTop = el.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < window.innerHeight - elementVisible) {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }
            });
        }

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            
            // Pré-animation des éléments
            const elements = document.querySelectorAll('.feature-card, .timeline-item, .semantic-card');
            elements.forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(50px)';
                el.style.transition = 'all 0.6s ease';
            });
            
            // Écouteurs d'événements
            window.addEventListener('scroll', animateOnScroll);
            document.getElementById('closeResult').addEventListener('click', closeResultWindow);
            document.getElementById('overlay').addEventListener('click', closeResultWindow);
            document.getElementById('copyButton').addEventListener('click', copyToClipboard);
            
            animateOnScroll(); // Appel initial
            
            // Suivi des événements pour les types de contenu
            document.querySelectorAll('.content-type').forEach(type => {
                type.addEventListener('click', function() {
                    const typeName = this.querySelector('div').textContent;
                    console.log(`Type de contenu sélectionné: ${typeName}`);
                });
            });
        });

        // Effet hover sur les cartes
        document.querySelectorAll('.content-type').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) rotateX(10deg) scale(1.05)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) rotateX(0deg) scale(1)';
            });
        });
    </script>
</body>
</html>