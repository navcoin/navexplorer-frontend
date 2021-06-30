class NumberFormat {
    format(x, decimals = true, fixed = 2) {
        if (typeof x === "undefined") {
            return false;
        }

        let parts = x.toString().split(".");

        parts[0] = this.numberWithCommas(parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        if (decimals === false) {
            return parts[0];
        }

        if (typeof parts[1] !== 'undefined') {
            parts[1] = '<small>' + parts[1].substring(0, fixed) + '</small>';
        }

        return parts.join(".");
    }

    formatSat(x, decimals = 8, sign = false) {
        x = x/100000000
        if (x < 1) {
            decimals = 10
        }
        x = x.toFixed(8).replace(/\.?0+$/,"")

        let signPrefix = (sign === true && x > 0) ? '+' : ''
        return signPrefix + this.format(x, decimals !== 0, decimals);
    }

    formatNav(x, decimals = true, isPrivate = false) {
        let number = this.format(x, decimals, 4);
        if (number === false) {
            return false;
        }

        return number + (isPrivate ? " xNav" : " Nav");
    }

    formatSatNav(x, decimals = 4, isPrivate = false, sign = false) {
        let number = this.formatSat(x, decimals, sign);
        if (number === false) {
            return false;
        }

        return number + (isPrivate ? " xNav" : " Nav");
    }

    numberWithCommas(x) {
        x = x.toString();
        var pattern = /(-?\d+)(\d{3})/;
        while (pattern.test(x))
            x = x.replace(pattern, "$1,$2");
        return x;
    }
}

export default new NumberFormat();