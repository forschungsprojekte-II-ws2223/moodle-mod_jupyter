/**
 *Single repository file for all ajax related webservice calls
 */
import { call as fetchMany } from 'core/ajax';

export const submitNotebook = () => fetchMany([{
    methodname: 'mod_jupyter_submit_notebook',
    args: {
    },
}])[0];
