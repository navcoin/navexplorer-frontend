export default class NavNumberFormat {
    format(x, decimals = true, fixed = 2) {
        if (typeof x === "undefined") {
            return false;
        }

        let parts = x.toString().split(".");

        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        if (decimals === false) {
            return parts[0];
        }

        if (typeof parts[1] !== 'undefined') {
            parts[1] = '<small>' + parts[1].substring(0, fixed) + '</small>';
        }

        return parts.join(".");
    }

    formatNav(x, decimals = true, isPrivate = false) {
        let number = this.format(x, decimals);
        if (number === false) {
            return false;
        }

        return number + (isPrivate ? " xNav" : " NAV");
    }
}