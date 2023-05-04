import { submitNotebook } from './repository';

const Selectors = {
    actions: {
        showAlertButton: '[data-action="mod_jupyter/submit-notebook_button"]',
    },
};

export const init = () => {
    document.addEventListener('click', e => {
        if (e.target.closest(Selectors.actions.showAlertButton)) {
            window.alert("Thank you for clicking on the button");
            callSubmitNotebook();
        }
    });
};

const callSubmitNotebook = async () => {
    const response = await submitNotebook();
    window.console.log(response);

};
