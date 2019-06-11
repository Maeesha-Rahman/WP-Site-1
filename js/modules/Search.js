import $ from 'jquery';

class Search {
    // 1. describe and create/initiate our object
    constructor() {
        this.resultsDiv = $('#search-overlay__results');
        this.openButton = $('.js-search-trigger');
        this.closeButton = $('.search-overlay__close');
        this.searchOverlay = $('.search-overlay');
        this.events();
        this.isOverlayOpen = false;
        this.searchField = $('#search-term');
        this.isSpinnerVisible = false;
        this.typingTimer;
    }

    // 2. events
    events() {
        // use bind to make 'this' keyword as the object search instead of this being referred to the html element - which on click method does
        this.openButton.on('click', this.openOverlay.bind(this));
        this.closeButton.on('click', this.closeOverlay.bind(this));
        $(document).on('keydown', this.keyPressDispatcher.bind(this));
        this.searchField.on('keyup', this. typingLogic.bind(this));
        this.previousValue;
        this.typingTimer;
    }

    // 3. methods (function, action)
    openOverlay() {
        this.searchOverlay.addClass('.search-overlay--active');
        $('body').addClass('body-no-scroll');
        console.log('our open method just ran.');
        this.isOverlayOpen = true;
    };

    closeOverlay() {
        this.searchOverlay.removeClass('.search-overlay--active');
        $('body').removeClass('body-no-scroll');
        console.log('our close method just ran.');
        this.isOverlayOpen = false;
    };

    keyPressDispatcher(e) {
        // console.log(e.keyCode);
        // s key
        // and if the overlay is not currently open && any input or textarea is not in focus
        if (e.keyCode === 83 && !this.isOverlayOpen && !$('input, textarea').is(':focus')) {
            this.openOverlay();
        }
        // esc key
        if (e.keyCode === 27 && this.isOverlayOpen) {
            this.closeOverlay();
        }
    };

    typingLogic() {
        if (this.searchField.val() !== this.previousValue) {
            // reset timer
            clearTimeout(this.typingTimer);

            if (this.searchField.val()) {
                // only if false
                if (!this.isSpinnerVisible) {
                    this.resultsDiv.html('<div class="spinner-loader"></div>');
                    this.isSpinnerVisible = true;
                }
                this.typingTimer = setTimeout(this.getResults().bind(this), 2000);
            } else {
                this.resultsDiv.html('');
                this.isSpinnerVisible = false;
            }
        }
        
        this.previousValue = this.searchField.val();
    };
    // arrow function does not change value of the 'this' keyword
    // since we used arrow cb function,'this' will still be pointing to our main object instead of the getJSON method since that's what executed the function
    getResults() {
        $.getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchField.val(), posts => {
            
            this.resultsDiv.html(`
            <h2 class="search-overlay__section-title">General Information</h2>
            // if posts.length = true (it's automatically true if greater than 0 since 0 is falsy)
            ${posts.length ? '<ul class="link-list min-list">' : '<p>No general information matches that search.</p>'}
                ${posts.map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
            ${posts.length ? '</ul>' : ''}
            `);
            this.isSpinnerVisible = false;
        });
    };
}

export default Search;