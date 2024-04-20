/**
 * A class that interacts with the dates across the app
 */
export default class DateHelper {
    /**
     * Format a given date to locale date string
     *
     * @param dateString
     * @returns {string}
     */
    static formatDate(dateString) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        const date = new Date(dateString);

        return date.toLocaleDateString('en-US', options);
    }
}
