<header>
    <div id="header">
        <p><a href="/">Raphaël MATHERET</a></p>
        <p><a href="/portfolio">À propos de moi</a></p>
        <p><a href="/portfolio/projets">Projets</a></p>
        <p><a href="/portfolio/contact">Contact</a></p>
        <p><a href="#" id="protectedLink">Log in</a></p>
    </div>

    <div class="modal-overlay" id="modalOverlay">

        <form id="passwordForm" method="POST" class="modal">
            <h2>Entrez le mot de passe</h2>
            <input type="password" id="passwordInput" placeholder="Mot de passe">
            <label for="passwordInput"></label>
            <input id="submitPassword" type="submit" value="Valider">
            <p class="error" id="errorMsg"></p>
        </form>
    </div>
</header>