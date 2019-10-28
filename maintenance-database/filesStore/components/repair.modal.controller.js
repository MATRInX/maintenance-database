(function () {
    'use strict';

    angular
    .module('fileStoreApp')
    .controller('repairModalController', repairModalController);

    function repairModalController($uibModalInstance, dataItems, $log, $timeout) {
        var vm = this;
        vm.type = dataItems.type;
        vm.repairData = dataItems.data;
        vm.repairDatePopup = false;

        vm.submitModal = submitModal;
        vm.closeModal = closeModal;

        ////////////////////
        function submitModal() {
            if (vm.type === 'edition') {
                var tempDate = new Date();
                vm.repairData.lastedit = dateToString(tempDate);
            }
            vm.repairData.estimatedRepairDate = dateToString(vm.repairData.estimatedRepairDate);
            $uibModalInstance.close(vm.repairData);
        }
        function closeModal() {
            $uibModalInstance.dismiss(false);
        }
        function dateToString(dateToConverse) {
            var tempDate = new Date(dateToConverse);
            var date = tempDate.getFullYear() + '-' + (tempDate.getMonth() + 1) + '-' + tempDate.getDate();
            var time = tempDate.getHours() + ':' + tempDate.getMinutes() + ':' + tempDate.getSeconds();
            return date + ' ' + time;
        }
    }
})();