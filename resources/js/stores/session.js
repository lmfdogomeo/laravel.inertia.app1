import { usePage } from '@inertiajs/vue3'
import { useStorage } from '@vueuse/core'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useSessionStore = defineStore('session', () => {
  const page = usePage();
  const user = page.props.auth.user || {};
  const uuid = page.props.auth.user.uuid || null;
  const role = page.props.auth.user.role || "";

  let modules = {};
  if (role.toLowerCase() === 'admin') {
    modules.merchant = ["add", 'edit', 'delete', 'view'];
    modules.account = ["add", 'edit', 'delete', 'view'];
    modules.product = ["add", 'edit', 'delete', 'view'];
  }
  else if (role.toLowerCase() === 'merchant') {
    modules.product = ['view'];
  }

  function hasPermission(module = "", action = "") {
    if (typeof modules[module] !== 'undefined') {
      const hasModule = modules[module] || [];
      return hasModule.includes(action)
    }
    return false;
  }

  function canEdit(module = "") {
    hasPermission(module, "edit");
  }

  function canDelete(module = "") {
    hasPermission(module, "delete");
  }

  function canAdd(module = "") {
    hasPermission(module, "add");
  }

  function canView(module = "") {
    hasPermission(module, "view");
  }
  
  return { user, uuid, role, canEdit, canAdd, canDelete, canView }
})
