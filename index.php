<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FichesNum – App micro-learning sociale nouvelle génération</title>
  <meta name="description" content="FichesNum, c'est la première app sociale de micro-learning : fiches interactives, feed communautaire, XP, leaderboard, tout pour apprendre et s’amuser sur mobile ou desktop.">
  <meta name="theme-color" content="#1877f2">
  <link rel="manifest" href="manifest.json">
  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    
    body {
      font-family: 'Inter', sans-serif;
    }
    
    .menu-overlay {
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s, visibility 0.3s;
    }
    
    .menu-overlay.active {
      opacity: 1;
      visibility: visible;
    }
    
    .side-menu {
      transform: translateX(100%);
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .side-menu.active {
      transform: translateX(0);
    }
    
    .menu-item {
      transition: all 0.2s ease;
    }
    
    .menu-item:hover {
      background-color: #f0f7ff;
      transform: translateX(5px);
    }
    
    .like-btn.animated {
      animation: likeAnimation 0.6s ease;
    }
    
    @keyframes likeAnimation {
      0% { transform: scale(1); }
      50% { transform: scale(1.2); }
      100% { transform: scale(1); }
    }
  </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
  <!-- Header -->
  <header class="w-full bg-blue-600 h-16 flex items-center justify-between px-4 md:px-8 sticky top-0 shadow-md z-10">
    <div class="flex items-center gap-2">
      <svg width="28" height="28" viewBox="0 0 28 28" fill="none"><rect x="4" y="5" width="20" height="18" rx="3.5" fill="#fff"/><rect x="4" y="5" width="20" height="18" rx="3.5" stroke="#42b72a" stroke-width="2"/><rect x="8" y="8" width="12" height="3" rx="1.5" fill="#1877f2"/><rect x="8" y="13" width="9" height="3" rx="1.5" fill="#e7eaf2"/></svg>
      <span class="font-bold text-xl text-white">FichesNum</span>
    </div>
    <button id="menuButton" class="w-9 h-9 rounded-full flex flex-col items-center justify-center bg-blue-500 hover:bg-blue-700 transition-all" aria-label="Ouvrir le menu">
      <span class="w-5 h-1 bg-white rounded mb-1 transition-transform"></span>
      <span class="w-5 h-1 bg-white rounded mb-1 transition-transform"></span>
      <span class="w-5 h-1 bg-white rounded transition-transform"></span>
    </button>
  </header>

  <!-- Menu Overlay -->
  <div id="menuOverlay" class="menu-overlay fixed inset-0 bg-black/50 z-20"></div>
  
  <!-- Side Menu -->
  <aside id="sideMenu" class="side-menu fixed top-0 right-0 h-full w-4/5 max-w-sm bg-white z-30 shadow-xl">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
      <div class="flex items-center gap-2">
        <svg width="28" height="28" viewBox="0 0 28 28" fill="none"><rect x="4" y="5" width="20" height="18" rx="3.5" fill="#1877f2"/><rect x="4" y="5" width="20" height="18" rx="3.5" stroke="#42b72a" stroke-width="2"/><rect x="8" y="8" width="12" height="3" rx="1.5" fill="#fff"/><rect x="8" y="13" width="9" height="3" rx="1.5" fill="#e7eaf2"/></svg>
        <span class="font-bold text-xl text-blue-700">FichesNum</span>
      </div>
      <button id="closeMenu" class="w-10 h-10 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
    
    <div class="p-4 flex items-center gap-3 border-b border-gray-200">
      <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Votre profil" class="w-12 h-12 rounded-full border-2 border-blue-200 object-cover">
      <div>
        <div class="font-bold text-gray-900">Emma Dubois</div>
        <div class="text-sm text-gray-500">Niveau 12 • 1560 XP</div>
      </div>
    </div>
    
    <nav class="py-3">
      <ul class="space-y-1">
        <li>
          <a href="#" class="menu-item flex items-center gap-3 p-4 text-gray-700 hover:text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="font-medium">Accueil</span>
          </a>
        </li>
        <li>
          <a href="#" class="menu-item flex items-center gap-3 p-4 text-gray-700 hover:text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <span class="font-medium">Explorer</span>
          </a>
        </li>
        <li>
          <a href="#" class="menu-item flex items-center gap-3 p-4 text-gray-700 hover:text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span class="font-medium">Mes Fiches</span>
          </a>
        </li>
        <li>
          <a href="#" class="menu-item flex items-center gap-3 p-4 text-gray-700 hover:text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span class="font-medium">Classement</span>
          </a>
        </li>
        <li>
          <a href="#" class="menu-item flex items-center gap-3 p-4 text-gray-700 hover:text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span class="font-medium">Paramètres</span>
          </a>
        </li>
        <li>
          <a href="#" class="menu-item flex items-center gap-3 p-4 text-gray-700 hover:text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span class="font-medium">Déconnexion</span>
          </a>
        </li>
      </ul>
    </nav>
    
    <div class="absolute bottom-0 left-0 right-0 p-4 bg-gray-50 border-t border-gray-200">
      <div class="text-center text-sm text-gray-500">
        Version 1.2.5 • © 2025 FichesNum
      </div>
    </div>
  </aside>

  <!-- Main -->
  <main class="w-full max-w-md mx-auto flex-1 px-2 sm:px-0 py-3">
    <!-- Stats -->
    <section class="flex gap-2 justify-between mt-3 mb-4 flex-wrap">
      <div class="bg-white rounded-xl shadow flex-1 min-w-[110px] py-2 px-3 text-blue-600 font-semibold text-center">👥<br><b>235</b> En ligne</div>
      <div class="bg-white rounded-xl shadow flex-1 min-w-[110px] py-2 px-3 text-blue-600 font-semibold text-center">📄<br><b>52</b> Fiches aujourd’hui</div>
      <div class="bg-white rounded-xl shadow flex-1 min-w-[110px] py-2 px-3 text-blue-600 font-semibold text-center">💬<br><b>134</b> Commentaires</div>
    </section>
    <!-- Feed -->
    <section aria-label="Mur social des fiches" class="flex flex-col gap-5">
      <!-- Fiche 1 -->
      <article tabindex="0" itemscope itemtype="https://schema.org/Article" class="bg-white rounded-2xl shadow px-5 py-4 focus:ring-2 focus:ring-blue-300 transition">
        <div class="flex items-center gap-3 mb-1">
          <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Marie MicroFiche" class="w-11 h-11 rounded-full border-2 border-gray-200 object-cover" loading="lazy">
          <div>
            <span class="font-bold text-blue-700" itemprop="author">Marie MicroFiche</span><br>
            <span class="text-xs text-gray-500" itemprop="datePublished">il y a 3 min</span>
          </div>
        </div>
        <div class="font-bold text-lg mb-1 text-gray-900" itemprop="headline">Comment écrire un mail pro (sans prise de tête)</div>
        <div class="text-gray-700 mb-2" itemprop="description">
          Pour un mail efficace : sois clair, bref et poli.<br>
          Bonus : une formule de politesse ne tue personne (même ton boss).
        </div>
        <div class="bg-gray-100 rounded-lg pl-3 pr-2 py-2 border-l-4 border-blue-600 text-gray-800 text-sm mb-2">
          <b>Exemple :</b><br>
          <em>Bonjour Claire,<br>
          Peux-tu m’envoyer le rapport avant 15h ?<br>
          Merci d’avance !<br>
          Bonne journée,<br>
          Kiki</em>
        </div>
        <div class="bg-blue-50 text-blue-900 rounded-lg px-3 py-2 text-sm font-medium mb-2">
          Quiz express :  
          <br>Quelle formule de politesse éviter dans un mail pro ?
          <br><span>A) Cordialement&nbsp;&nbsp;B) Bisous&nbsp;&nbsp;C) Bien à vous</span>
        </div>
        <div class="flex gap-3 mt-1">
          <button class="flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 border border-gray-200 text-gray-700 hover:bg-blue-100 active:bg-blue-200 font-semibold transition like-btn" onclick="toggleLike(this)">
            👍 J’aime <span class="like-count ml-1">24</span>
          </button>
          <button class="flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 border border-gray-200 text-gray-700 hover:bg-blue-100 active:bg-blue-200 font-semibold transition" onclick="toggleComments(this)">
            💬 Commenter
          </button>
          <button class="flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 border border-gray-200 text-gray-700 hover:bg-green-100 active:bg-green-200 font-semibold transition" onclick="alert('Partage et tes potes deviendront brillants !')">
            ↗️ Partager
          </button>
        </div>
        <div class="comments mt-2 bg-gray-50 rounded-lg p-3 text-sm text-gray-700 hidden">
          <b>Paul :</b> Trop utile, j’envoyais toujours “Bisous” à mon patron…<br>
          <b>Sophie :</b> Merci pour la fiche !<br>
          <b>Julien :</b> Et pour écrire à sa belle-mère, on fait comment ? 😆
        </div>
      </article>
      <!-- Fiche 2 -->
      <article tabindex="0" itemscope itemtype="https://schema.org/Article" class="bg-white rounded-2xl shadow px-5 py-4 focus:ring-2 focus:ring-blue-300 transition">
        <div class="flex items-center gap-3 mb-1">
          <img src="https://randomuser.me/api/portraits/men/34.jpg" alt="Paul Polyglotte" class="w-11 h-11 rounded-full border-2 border-gray-200 object-cover" loading="lazy">
          <div>
            <span class="font-bold text-blue-700" itemprop="author">Paul Polyglotte</span><br>
            <span class="text-xs text-gray-500" itemprop="datePublished">il y a 1 h</span>
          </div>
        </div>
        <div class="font-bold text-lg mb-1 text-gray-900" itemprop="headline">Dire « bonjour » en 7 langues (sans se tromper)</div>
        <div class="text-gray-700 mb-2" itemprop="description">
          Apprends à dire bonjour sans insulter ta belle-mère à l’international.<br>
          Parfait pour briller en voyage ou au bureau.
        </div>
        <div class="bg-gray-100 rounded-lg pl-3 pr-2 py-2 border-l-4 border-blue-600 text-gray-800 text-sm mb-2">
          <b>Exemples :</b> Hello (Anglais), Hola (Espagnol), Hallo (Allemand), Ciao (Italien), Konnichiwa (Japonais), Salam (Arabe), Jambo (Swahili)
        </div>
        <div class="bg-blue-50 text-blue-900 rounded-lg px-3 py-2 text-sm font-medium mb-2">
          Quiz express :<br>
          Quel pays dit “Konnichiwa” ?<br>
          <span>A) Japon&nbsp;&nbsp;B) Brésil&nbsp;&nbsp;C) Russie</span>
        </div>
        <div class="flex gap-3 mt-1">
          <button class="flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 border border-gray-200 text-gray-700 hover:bg-blue-100 active:bg-blue-200 font-semibold transition like-btn" onclick="toggleLike(this)">
            👍 J’aime <span class="like-count ml-1">9</span>
          </button>
          <button class="flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 border border-gray-200 text-gray-700 hover:bg-blue-100 active:bg-blue-200 font-semibold transition" onclick="toggleComments(this)">
            💬 Commenter
          </button>
          <button class="flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 border border-gray-200 text-gray-700 hover:bg-green-100 active:bg-green-200 font-semibold transition" onclick="alert('Partage et tu deviens un globe-trotter du cerveau !')">
            ↗️ Partager
          </button>
        </div>
        <div class="comments mt-2 bg-gray-50 rounded-lg p-3 text-sm text-gray-700 hidden">
          <b>Amine :</b> J’ai essayé “Hola” au Japon, j’ai eu droit à un regard bizarre…<br>
          <b>Lucie :</b> J’adore ces fiches !<br>
          <b>Mamie :</b> Moi j’apprends “Ciao” pour draguer à la pétanque.
        </div>
      </article>
    </section>
    <!-- Leaderboard -->
    <section class="mt-8 mb-5" aria-labelledby="top-learners">
      <h2 class="text-blue-700 font-bold text-base mb-3" id="top-learners">Best Learners 🏆</h2>
      <div class="flex gap-3 overflow-x-auto pb-2">
        <div class="bg-white rounded-xl shadow px-5 py-3 min-w-[120px] text-center border border-gray-200">
          <div class="font-bold text-white bg-blue-600 rounded-full w-8 h-8 flex items-center justify-center mx-auto mb-1">1</div>
          <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Top 1" class="w-8 h-8 rounded-full border-2 border-white mx-auto mb-1">
          <div class="font-bold text-gray-800">Sophie</div>
          <div class="text-green-600 font-semibold text-sm">2040 XP</div>
        </div>
        <div class="bg-white rounded-xl shadow px-5 py-3 min-w-[120px] text-center border border-gray-200">
          <div class="font-bold text-yellow-600 bg-yellow-300 rounded-full w-8 h-8 flex items-center justify-center mx-auto mb-1">2</div>
          <img src="https://randomuser.me/api/portraits/men/36.jpg" alt="Top 2" class="w-8 h-8 rounded-full border-2 border-white mx-auto mb-1">
          <div class="font-bold text-gray-800">Julien</div>
          <div class="text-green-600 font-semibold text-sm">1810 XP</div>
        </div>
        <div class="bg-white rounded-xl shadow px-5 py-3 min-w-[120px] text-center border border-gray-200">
          <div class="font-bold text-gray-600 bg-gray-200 rounded-full w-8 h-8 flex items-center justify-center mx-auto mb-1">3</div>
          <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Top 3" class="w-8 h-8 rounded-full border-2 border-white mx-auto mb-1">
          <div class="font-bold text-gray-800">Mehdi</div>
          <div class="text-green-600 font-semibold text-sm">1725 XP</div>
        </div>
        <div class="bg-white rounded-xl shadow px-5 py-3 min-w-[120px] text-center border border-gray-200">
          <div class="font-bold text-orange-800 bg-orange-300 rounded-full w-8 h-8 flex items-center justify-center mx-auto mb-1">4</div>
          <img src="https://randomuser.me/api/portraits/women/29.jpg" alt="Top 4" class="w-8 h-8 rounded-full border-2 border-white mx-auto mb-1">
          <div class="font-bold text-gray-800">Clara</div>
          <div class="text-green-600 font-semibold text-sm">1630 XP</div>
        </div>
      </div>
    </section>
  </main>
  <!-- FAB pour ajouter une fiche -->
  <button class="fixed right-6 bottom-8 w-16 h-16 rounded-full bg-blue-600 hover:bg-green-500 shadow-xl flex items-center justify-center text-white text-3xl z-30 transition-all" aria-label="Nouvelle fiche" onclick="alert('Bientôt, tu pourras créer ta fiche !')">
    +
  </button>
  <footer class="mt-6 mb-4 text-center text-gray-500 text-sm opacity-90">
    © 2025 FichesNum – L’app micro-learning qui rend tes pauses intelligentes.<br>
    <span class="text-xs">Fait avec ❤️ et un soupçon de génie (artificiel).</span>
  </footer>
  <script>
    // Menu functionality
    const menuButton = document.getElementById('menuButton');
    const closeMenu = document.getElementById('closeMenu');
    const menuOverlay = document.getElementById('menuOverlay');
    const sideMenu = document.getElementById('sideMenu');
    
    function openMenu() {
      menuOverlay.classList.add('active');
      sideMenu.classList.add('active');
      document.body.style.overflow = 'hidden';
    }
    
    function closeMenuFunc() {
      menuOverlay.classList.remove('active');
      sideMenu.classList.remove('active');
      document.body.style.overflow = '';
    }
    
    menuButton.addEventListener('click', openMenu);
    closeMenu.addEventListener('click', closeMenuFunc);
    menuOverlay.addEventListener('click', closeMenuFunc);
    
    // Like button effect
    function toggleLike(btn) {
      btn.classList.add('animated');
      btn.classList.toggle('bg-blue-600');
      btn.classList.toggle('text-white');
      btn.classList.toggle('border-blue-700');
      let span = btn.querySelector('.like-count');
      let count = parseInt(span.textContent, 10) || 0;
      if (btn.classList.contains('bg-blue-600')) span.textContent = count + 1;
      else span.textContent = count - 1;
      
      setTimeout(() => {
        btn.classList.remove('animated');
      }, 600);
    }
    
    // Show/hide comments
    function toggleComments(btn) {
      let comments = btn.closest('article').querySelector('.comments');
      comments.classList.toggle('hidden');
      if (!comments.classList.contains('hidden')) {
        setTimeout(()=>comments.scrollIntoView({behavior:'smooth', block:'end'}), 100);
      }
    }
    
    // Close menu when pressing escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && sideMenu.classList.contains('active')) {
        closeMenuFunc();
      }
    });
  </script>
</body>
</html>
