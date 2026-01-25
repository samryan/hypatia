<?php
/**
 * Search modal template
 *
 * @package Hypatia
 */
?>
<div id="search-modal" class="search-modal" role="dialog" aria-modal="true" aria-labelledby="search-modal-title" aria-hidden="true">
  <div class="search-modal__backdrop">
    <div class="search-modal__dialog">
      <h2 id="search-modal-title" class="sr-only">Search</h2>

      <div class="search-modal__input-wrap">
        <input
          type="search"
          id="search-input"
          class="search-modal__input"
          placeholder="Search..."
          autocomplete="off"
          aria-describedby="search-modal-hint"
        />
        <button type="button" class="search-modal__close" aria-label="Close search">
          <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor">
            <path d="M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z"/>
          </svg>
        </button>
      </div>

      <div id="search-results" class="search-modal__results" role="listbox"></div>

      <div class="search-modal__footer" id="search-modal-hint">
        <span class="search-modal__hint"><kbd>↑</kbd><kbd>↓</kbd> to navigate</span>
        <span class="search-modal__hint"><kbd>↵</kbd> to select</span>
        <span class="search-modal__hint"><kbd>esc</kbd> to close</span>
      </div>
    </div>
  </div>
</div>
