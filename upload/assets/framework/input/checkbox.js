import { WebComponent } from '../library/webcomponent.js';
import { loader } from '../index.js';

const language = loader.language('default');

class XCheckbox extends WebComponent {
    static observed = ['checked'];
    option = [];

    async connected() {
        this.option = this.querySelectorAll('option');
    };

    render() {
        let html = '<div id="' + this.getAttribute('input-id') + '" class="form-control" style="height: 150px; overflow: auto;">';

        for (let option of this.option) {
            html += '<div class="form-check">';
            html += '   <input type="checkbox"';

            if (option.hasAttribute('value')) {
                html += ' value="' + option.getAttribute('value') + '"';
            }

            if (option.hasAttribute('input-id')) {
                html += ' id="' + option.getAttribute('input-id') + '"';
            }

            html += 'class="form-check-input"';

            if (option.hasAttribute('target')) {
                html += ' data-on="change:onChange" data-target="' + option.getAttribute('target') + '"';
            }

            if (option.hasAttribute('checked')) {
                html += ' checked';
            }

            html += '/>';
            html += '   <label for="' + option.getAttribute('input-id') + '" class="form-check-label">' + option.innerHTML + '</label>';
            html += '</div>';
        }

        html += '</div>';

        return html;
    }

    onChange(e) {
        console.log('onChange', e.target.checked);

        let target = document.getElementById(e.target.getAttribute('data-target'));

        let options = target.querySelectorAll('input[type=\'checkbox\']');

        console.log('onChange', options);

        for (let option of options) {
            option.setAttribute('checked', e.target.checked ? 1 : 0);
        }

        console.log('onChange', target);
    }
}

customElements.define('x-checkbox', XCheckbox);