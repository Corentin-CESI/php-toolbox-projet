<?php
    /** Charge la barre latérale de navigation */
    template('header', array(
        'title' => 'Boite à outils • Règle de trois',
    ));
?>

    <!-- ======= REGLE DE TROIS ======= -->
    <section id="homepage" class="homepage">
        <div class="container-fluid row position-relative">
            <div class="section-title col-11 mx-auto">
                <h2>La règle de trois</h2>
            </div>

            <div class="col-11 mx-auto">
                <figure class="bg-light rounded p-3">
                    <blockquote cite="https://www.huxley.net/bnw/four.html">
                        <p>En mathématiques élémentaires, la règle de trois ou règle de proportionnalité ou produit en croix est une méthode mathématique permettant de déterminer une quatrième proportionnelle. Plus précisément, trois nombres a, b et c étant donnés, la règle de trois permet, à partir de l'égalité des produits en croix, de trouver le nombre d tel que (a, b) soit proportionnel à (c, d).</p>
                    </blockquote>
                    <figcaption><cite><a href="https://fr.wikipedia.org/wiki/R%C3%A8gle_de_trois">Wikipedia</a></cite></figcaption>
                </figure>
            </div>

            <div class="col-11 mx-auto">
                <div class="container-fluid row">
                    <fieldset class="col-11 mt-4 mx-auto">
                        <legend>Calculer X</legend>
                        <form action="" method="POST" name="regle-de-trois">
                            <div class="form-group d-flex d-inline">
                                <div class="col">
                                    <label for="a" aria-hidden="true" hidden>Nombre A</label>
                                    <div class="input-group">
                                        <input id="a" name="a" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="d-inline-flex align-items-center">
                                    <span class="ver"> -> </span>
                                </div>
                                <div class="col">
                                    <label for="c" aria-hidden="true" hidden>Nombre C</label>
                                    <div class="input-group">
                                        <input id="c" name="c" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group d-flex d-inline mt-2">
                                <div class="col">
                                    <label for="b" aria-hidden="true" hidden>Nombre B</label>
                                    <div class="input-group">
                                        <input id="b" name="b" type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <span class="ver"> -> </span>
                                </div>
                                <div class="col">
                                    <label for="d" aria-hidden="true" hidden>Nombre D</label>
                                    <div class="input-group">
                                        <input id="d" name="d" type="text" class="form-control" disabled value="X">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group d-flex d-inline mt-3 mb-2">
                                <div class="col-3 mx-auto text-center">
                                    <button name="submit" type="submit" class="btn btn-primary btn-block col-12">Calculer</button>
                                </div>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>

            <div id="loading" class="position-absolute top-50 start-50 translate-middle" style="max-width:fit-content; display: none;">
                <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================== -->

    <script type="text/javascript">
        window.addEventListener('load', () => {
            /** Récupère tous les FORM dans la page HTML */
            let forms = document.forms;

            for(form of forms){
                form.addEventListener('submit', async (event) => {
                    /** Permet de bloquer les actions par défaut des pages web (ex: redirection vers une 
                     *  page lors d'une sélection de lien) 
                     * */
                    event.preventDefault();

                    /** Permet de récuper toutes les pairs de clé (Name d'un input) et sa valeur (la VALUE) */
                    const formData = new FormData(event.target).entries()

                    /** Renvoi un objet JSON avec dans DATA le résultat de la convertion monétaire de la forme :
                     *              -  : {d: 4}
                     */
                    const response = await fetch('/api/post', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(
                            Object.assign(Object.fromEntries(formData), {form: event.target.name})
                        )
                    });

                    const result = await response.json();

                    /** inputName prend la première colonne du résultat dans DATA (d) */
                    let inputName = Object.keys(result.data)[0];

                    /** Sélection sur le NAME de l'élément de la page HTML */
                    event.target.querySelector(`input[name="${inputName}"]`).value = result.data[inputName];
                
                    /** Enlève le LOADING SPINNER */
                    document.getElementById('loading').style.display = 'none';
                });
            }
        });

        /** Attend l'activation du BUTTON d'envoi du formulaire pour afficher le 
         *  LOADING SPINNER. 
         * */
        const trois = document.getElementsByName('regle-de-trois');

        trois.forEach(element => {
            element.addEventListener('submit', function() {
                document.getElementById('loading').style.display = 'block';
            }); 
        });
    </script>

<?php 
    /** Charge la fin de la page HTML */
    template('footer');
