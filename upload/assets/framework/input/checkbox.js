import { WebComponent } from '../library/webcomponent.js';
import { loader } from '../index.js';

const language = loader.language('default');

customElements.define('checkbox-all', class extends WebComponent {
    render() {
        let html = '';

        html += '<div class="form-check">';
        html += '   <input type="checkbox" id="' + this.getAttribute('input-id') + '" class="form-check-input" data-on="change:onChange" data-target="' + this.getAttribute('target') + '"/>';
        html += '   <label for="' + this.getAttribute('input-id') + '" class="form-check-label">' + this.innerHTML + '</label>';
        html += '</div>';

        return html;
    }

    onChange(e) {
        let target = document.getElementById(e.target.getAttribute('data-target'));

        const filtered = Array.from(target.querySelectorAll('input[type=\'checkbox\']')).filter(element => {
            return !element.parentElement.parentElement.matches('checkbox-all');
        });

        for (let checkbox of filtered) {
            if (e.target.checked) {
                checkbox.setAttribute('checked', '');
            } else {
                checkbox.removeAttribute('checked');
            }
        }
    }
});