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
