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
    <link rel="stylesheet" href="assets/css/main.css">
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
    <script src="assets/js/main.js"></script>
</body>
</html>