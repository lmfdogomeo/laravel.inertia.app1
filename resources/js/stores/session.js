import { usePage } from '@inertiajs/vue3'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useSessionStore = defineStore('session', () => {
  let role = "";
  let user = {};
  let uuid = null;
  let modules = {};

  function initStore() {
    const page = usePage();
    user = page.props.auth?.user || {};
    uuid = page.props.auth?.user?.uuid || null;
    role = page.props.auth?.user?.role || "";

    // reset modules
    modules = {};

    if (role.toLowerCase() === 'admin') {
      modules.merchant = ["add", 'edit', 'delete', 'view'];
      modules.account = ["add", 'edit', 'delete', 'view'];
      modules.product = ["add", 'edit', 'delete', 'view'];
      modules["total-merchant"] = ["view"];
      modules["total-product"] = ["view"];
      modules["total-user"] = ["view"];
      modules["analytic-chart"] = ["view"];
      modules["line-chart-user"] = ["view"];
      modules["line-chart-product"] = ["view"];
      modules["line-chart-merchant"] = ["view"];
    }
    else if (role.toLowerCase() === 'merchant') {
      modules.product = ['view'];
      modules["line-chart-product"] = ["view"];
    }
  }

  initStore();
  
  function hasPermission(module = "", action = "") {
    if (typeof modules[module] !== 'undefined') {
      const hasModule = modules[module] || [];
      return hasModule.includes(action)
    }
    return false;
  }

  function canEdit(module = "") {
    // console.log(`hasPermission(${module}, "edit")`, hasPermission(module, "edit"))
    return hasPermission(module, "edit");
  }

  function canDelete(module = "") {
    // console.log(`hasPermission(${module}, "delete")`, hasPermission(module, "delete"))
    return hasPermission(module, "delete");
  }

  function canAdd(module = "") {
    // console.log(`hasPermission(${module}, "add")`, hasPermission(module, "add"))
    return hasPermission(module, "add");
  }

  function canView(module = "") {
    // console.log(`hasPermission(${module}, "view")`, hasPermission(module, "view"))
    return hasPermission(module, "view");
  }
  
  return { user, uuid, role, canEdit, canAdd, canDelete, canView, initStore }
})
