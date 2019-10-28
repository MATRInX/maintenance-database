(function () {
    'use strict';

    angular
        .module('customFilter', [])
        .filter('pagination', paginationFilter);

    paginationFilter.$inject = ['$filter', '$log'];

    function paginationFilter($filter, $log) {
        return pagination;

        function pagination(data, page, size) {
            if (angular.isArray(data) && angular.isNumber(page) && angular.isNumber(size)) {
                var startIndex = (page - 1) * size;
                if (data.length < startIndex) {
                    return [];
                }
                else {
                    var temp = $filter('limitTo')(data, size, startIndex);
                    return temp;
                }
            }
            else {
                return data;
            }
        }
    }
})();