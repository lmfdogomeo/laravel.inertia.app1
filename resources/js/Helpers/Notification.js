export const fire = (props = { title: " Message Sent Successfully ", message: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. ", duration: 2000, type: "success", icon: "" }) => {
  // Create a <style> element
  const style = document.createElement('style');
  style.type = 'text/css';

  // Add the CSS rules for the animations
  style.innerHTML = `
    @keyframes slideIn {
      from {
          transform: translateX(110%);
      }
      to {
          transform: translateX(0);
      }
    }

    @keyframes slideOut {
      from {
          transform: translateX(0);
      }
      to {
          transform: translateX(110%);
      }
    }

    .show {
      display: block; /* Show the element */
      animation: slideIn 0.3s forwards;
    }

    .hide {
      animation: slideOut 0.3s forwards;
      display: block; /* Ensure it's visible for the slide out animation */
    }

    #alert-1 {
      display: none; /* Initially hidden */
    }
  `;

  // Append the <style> element to the document's head
  document.head.appendChild(style);

  const el = document.createElement('div');
  el.classList = "fixed top-5 right-5 z-[9999]";
  el.id = "alert-1";

  el.innerHTML = `
    <div class="px-6 py-4 pr-10 text-white border-0 rounded bg-[#34D399] shadow-[rgba(13,_38,_76,_0.19)_0px_9px_20px]">
      <span class="inline-block mr-5 text-xl align-middle">
        <i class="fas fa-bell"></i>
      </span>
      <span class="inline-block mr-8 align-middle">
        <b class="capitalize">${props.title}</b> 
        ${props.message}
      </span>
      <button
        class="absolute top-0 right-0 text-2xl font-semibold leading-none bg-transparent outline-none focus:outline-none py-0 px-3 h-full"
        id="btn-close-alert"
      >
        <span>×</span>
      </button>
    </div>
  `;

  document.body.appendChild(el);

  const alert = document.querySelector('#alert-1');
  alert.style.display = 'block';
  alert.classList.add('show');

  const hideAlert = () => {
    const alert = document.querySelector('#alert-1');
    alert.classList.remove('show');
    alert.classList.add('hide');

    el.addEventListener('animationend', () => {
      style.remove();
      alert.remove();
    }, { once: true });
  }

  let timeout = null;

  if (props.duration > 0) {
    timeout = setTimeout(() => {
      hideAlert();
    }, props.duration);
  }

  const btnClose = document.querySelector('#btn-close-alert');
  btnClose.addEventListener('click', () => {
    clearTimeout(timeout);
    hideAlert();
  })

};

export default {
  fire
}
