import { submitNotebook } from './repository';

const Selectors = {
    actions: {
        showAlertButton: '[data-action="mod_jupyter/submit-notebook_button"]',
    },
};

export const init = async ({ user, contextid }) => {
    document.addEventListener('click', e => {
        if (e.target.closest(Selectors.actions.showAlertButton)) {
            window.alert("Thank you for clicking on the button");
            callSubmitNotebook(user, contextid);
        }
    });
};

const callSubmitNotebook = async (user, contextid) => {
    const response = await submitNotebook(user, contextid);
    window.console.log(response);

};
