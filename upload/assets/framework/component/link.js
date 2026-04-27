import { WebComponent } from '../library/webcomponent.js';

customElements.define('x-link', class extends WebComponent {
    static observed= [
        'href',
        'target'
    ];

    text = '';

    get href() {
        return this.getAttribute('href');
    }

    set href(href) {
        this.setAttribute('href', href);
    }

    get target() {
        return this.getAttribute('target');
    }

    set target(target) {
        this.setAttribute('target', target);
    }

    connected() {
        this.text = this.innerHTML;
    }

    render() {
        return '<a href="' + this.href + '" data-on="click:onClick">' + this.text + '</a>';
    }

    onClick(e) {
        if (this.target) e.preventDefault();

        let target = document.getElementById(this.target);

        target.src = this.href;

        console.log(target.src);
    }
});