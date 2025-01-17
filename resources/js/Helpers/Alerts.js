export const createAlert = (props = { title: " Message Sent Successfully ", message: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. ", duration: 2000, type: "success", icon: "" }) => {
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
  el.classList = "bg-white shadow-[rgba(13,_38,_76,_0.19)_0px_9px_20px] fixed top-5 right-5 z-[9999]";
  el.id = "alert-1";

  let wrapCss = "border-[#34D399] bg-[#34D399]";
  let svgBg = 'bg-[#34D399]';
  let svg = `
    <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.2984 0.826822L15.2868 0.811827L15.2741 0.797751C14.9173 0.401867 14.3238 0.400754 13.9657 0.794406L5.91888 9.45376L2.05667 5.2868C1.69856 4.89287 1.10487 4.89389 0.747996 5.28987C0.417335 5.65675 0.417335 6.22337 0.747996 6.59026L0.747959 6.59029L0.752701 6.59541L4.86742 11.0348C5.14445 11.3405 5.52858 11.5 5.89581 11.5C6.29242 11.5 6.65178 11.3355 6.92401 11.035L15.2162 2.11161C15.5833 1.74452 15.576 1.18615 15.2984 0.826822Z" fill="white" stroke="white"></path></svg>
  `;
  let titleCss = "text-lg text-black dark:text-[#34D399]";
  let msgElement = `<p class="text-base leading-relaxed text-body">${props.message}</p>`;

  if (props.type === 'error') {
    wrapCss = "border-[#F87171] bg-[#F87171]";
    svg = `
      <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.4917 7.65579L11.106 12.2645C11.2545 12.4128 11.4715 12.5 11.6738 12.5C11.8762 12.5 12.0931 12.4128 12.2416 12.2645C12.5621 11.9445 12.5623 11.4317 12.2423 11.1114C12.2422 11.1113 12.2422 11.1113 12.2422 11.1113C12.242 11.1111 12.2418 11.1109 12.2416 11.1107L7.64539 6.50351L12.2589 1.91221L12.2595 1.91158C12.5802 1.59132 12.5802 1.07805 12.2595 0.757793C11.9393 0.437994 11.4268 0.437869 11.1064 0.757418C11.1063 0.757543 11.1062 0.757668 11.106 0.757793L6.49234 5.34931L1.89459 0.740581L1.89396 0.739942C1.57364 0.420019 1.0608 0.420019 0.740487 0.739944C0.42005 1.05999 0.419837 1.57279 0.73985 1.89309L6.4917 7.65579ZM6.4917 7.65579L1.89459 12.2639L1.89395 12.2645C1.74546 12.4128 1.52854 12.5 1.32616 12.5C1.12377 12.5 0.906853 12.4128 0.758361 12.2645L1.1117 11.9108L0.758358 12.2645C0.437984 11.9445 0.437708 11.4319 0.757539 11.1116C0.757812 11.1113 0.758086 11.111 0.75836 11.1107L5.33864 6.50287L0.740487 1.89373L6.4917 7.65579Z" fill="#ffffff" stroke="#ffffff"></path></svg>
    `;
    svgBg = 'bg-[#F87171]';
    titleCss = "text-[#B45454]";
    msgElement = `<ul><li class="leading-relaxed text-[#CD5D5D]">${props.message}</li></ul>`;
  }

  el.innerHTML = `
    <div
      class="flex w-full border-l-6 bg-opacity-[15%] px-3 py-4 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30 md:p-5 ${wrapCss}"
    >
      <div
        class="mr-5 flex h-9 w-full max-w-[36px] items-center justify-center rounded-lg ${svgBg}"
      >
        ${svg}
      </div>
      <div class="w-full">
        <h5 class="mb-3 font-bold ${titleCss}">
        ${props.title}
        </h5>
        ${msgElement}
      </div>
    </div>
  `;

  document.body.appendChild(el);

  const alert = document.querySelector('#alert-1');
  alert.style.display = 'block';
  alert.classList.add('show');

  if (props.duration > 0) {
    setTimeout(() => {
      const alert = document.querySelector('#alert-1');
      alert.classList.remove('show');
      alert.classList.add('hide');

      el.addEventListener('animationend', () => {
        style.remove();
        alert.remove();
      }, { once: true });
    }, props.duration);
  }
};

export default {
  createAlert
}
