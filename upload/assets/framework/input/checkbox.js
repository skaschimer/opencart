import { WebComponent } from '../library/webcomponent.js';
import { loader } from '../index.js';

const language = loader.language('default');

customElements.define('checkbox-all', class extends WebComponent {
    render() {
        return '<input type="checkbox"' + (this.hasAttribute('input-id') ? ' id="' + this.getAttribute('input-id') + '"' : '') + ' class="form-check-input" data-on="change:onChange" data-target="' + this.getAttribute('target') + '"/>';
    }

    onChange(e) {
        let target = document.getElementById(e.target.getAttribute('data-target'));

        Array.from(target.querySelectorAll('input[type=\'checkbox\']')).filter(element => {
            if (!element.parentElement.matches('checkbox-all')) {
                if (e.target.checked) {
                    element.setAttribute('checked', '');
                } else {
                    element.removeAttribute('checked');
                }
            }
        });
    }
});