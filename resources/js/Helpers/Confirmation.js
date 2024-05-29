export const confirm = (props = { title: "Confirmation ", text: "Click OK to continue", type: "success", cancelButtonText: "Cancel", confirmButtonText: "Continue" }) => {
  return new Promise((resolve, reject) => {
    // Create a <style> element
    const style = document.createElement('style');
    style.type = 'text/css';

    // Add the CSS rules for the animations
    style.innerHTML = `
      @keyframes slideInDown {
        from {
          transform: translateY(-100%);
        }
        to {
          transform: translateY(0);
        }
      }
      @keyframes slideOutDown {
        from {
          transform: translateY(0);
        }
        to {
          transform: translateY(-200%);
        }
      }

      @keyframes popupIn {
        0% {
          transform: scale(0);
        }
        50% {
          transform: scale(1.1);
        }
        100% {
          transform: scale(1);
        }
      }

      @keyframes popupOut {
        0% {
          transform: scale(1);
        }
        50% {
          transform: scale(1.1);
        }
        100% {
          transform: scale(0);
        }
      }

      .popup-in {
        animation: popupIn 0.2s forwards;
      }

      .popup-out {
        animation: popupOut 0.2s forwards;
      }

      .slide-down-in {
        animation: slideInDown 0.3s forwards;
      }

      .slide-down-out {
        animation: slideOutDown 0.3s forwards;
      }
    `;

    // Append the <style> element to the document's head
    document.head.appendChild(style);

    const mainEl = document.createElement('div');
    mainEl.classList = "fixed top-0 left-0 flex items-center justify-center w-full h-full min-h-screen px-4 py-5 z-999999 bg-black/90";
    mainEl.id = "confirm-1";

    let animateIn = 'popup-in';
    let animateOut = 'popup-out';
    let icon = `
      <svg
        width="60"
        height="60"
        viewBox="0 0 60 60"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <rect opacity="0.1" width="60" height="60" rx="30" fill="#DC2626"></rect>
        <path
          d="M30 27.2498V29.9998V27.2498ZM30 35.4999H30.0134H30ZM20.6914 41H39.3086C41.3778 41 42.6704 38.7078 41.6358 36.8749L32.3272 20.3747C31.2926 18.5418 28.7074 18.5418 27.6728 20.3747L18.3642 36.8749C17.3296 38.7078 18.6222 41 20.6914 41Z"
          stroke="#DC2626"
          stroke-width="2.2"
          stroke-linecap="round"
          stroke-linejoin="round"
        ></path>
      </svg>
    `;

    if (props.type === 'confirm') {
      icon = `
        <svg
          width="60"
          height="60"
          viewBox="0 0 60 60"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <rect opacity="0.1" width="60" height="60" rx="30" fill="#DC2626"></rect>
          <path
            d="M30 27.2498V29.9998V27.2498ZM30 35.4999H30.0134H30ZM20.6914 41H39.3086C41.3778 41 42.6704 38.7078 41.6358 36.8749L32.3272 20.3747C31.2926 18.5418 28.7074 18.5418 27.6728 20.3747L18.3642 36.8749C17.3296 38.7078 18.6222 41 20.6914 41Z"
            stroke="#DC2626"
            stroke-width="2.2"
            stroke-linecap="round"
            stroke-linejoin="round"
          ></path>
        </svg>
      `;
    }

    mainEl.innerHTML = `
      <div
        class="confirm-body w-full max-w-142.5 rounded-lg bg-white py-12 px-8 text-center dark:bg-boxdark md:py-15 md:px-17.5 ${animateIn}"
      >
        <span class="inline-block mx-auto">
          ${icon}
        </span>
        <h3
          class="mt-5.5 pb-2 text-xl font-bold text-black dark:text-white sm:text-2xl"
        >
          ${props.title}
        </h3>
        <p class="mb-10 font-medium">
          ${props.text}
        </p>
        <div class="flex flex-wrap -mx-3 gap-y-4">
          <div class="w-full px-3 2xsm:w-1/2">
            <button
              type="button"
              id="btn-close-modal"
              class="block w-full p-3 font-medium text-center text-black transition border rounded border-stroke bg-gray hover:border-meta-1 hover:bg-meta-1 hover:text-white dark:border-strokedark dark:bg-meta-4 dark:text-white dark:hover:border-meta-1 dark:hover:bg-meta-1"
            >
              ${props.cancelButtonText}
            </button>
          </div>
          <div class="w-full px-3 2xsm:w-1/2">
            <button
              type="button"
              id="btn-confirm-modal"
              class="block w-full p-3 font-medium text-center text-white transition border rounded border-meta-1 bg-meta-1 hover:bg-opacity-90"
            >
              ${props.confirmButtonText}
            </button>
          </div>
        </div>
      </div>
    `;

    document.body.appendChild(mainEl);

    const hideConfirm = (action = "cancel") => {
      const confirmBody = document.querySelector('#confirm-1 .confirm-body');
      confirmBody.classList.remove(animateIn);
      confirmBody.classList.add(animateOut);

      confirmBody.addEventListener('animationend', () => {
        style.remove();

        const confirmBackdrop = document.querySelector('#confirm-1');
        confirmBackdrop.remove();

        if (action === 'cancel') {
          resolve({ isCancel: true, isConfirm: false, actionButton: true, actionBackdrop: false });
        }
        else if (action === 'confirm') {
          resolve({ isCancel: false, isConfirm: true, actionButton: true, actionBackdrop: false });
        }
        
      }, { once: true });
    }

    const btnClose = document.querySelector('#btn-close-modal');
    btnClose.addEventListener('click', () => {
      hideConfirm('cancel');
    });

    const btnConfirm = document.querySelector('#btn-confirm-modal');
    btnConfirm.addEventListener('click', () => {
      hideConfirm('confirm');
    });
  });
};

export default {
  confirm
}
