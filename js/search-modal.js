(function() {
  'use strict';

  const modal = document.getElementById('search-modal');
  const trigger = document.getElementById('search-trigger');
  const input = document.getElementById('search-input');
  const resultsContainer = document.getElementById('search-results');
  const backdrop = modal.querySelector('.search-modal__backdrop');
  const closeBtn = modal.querySelector('.search-modal__close');

  let lastFocusedElement = null;
  let debounceTimer = null;
  let selectedIndex = -1;
  let currentResults = [];

  // Update scroll shadow visibility (scroll-aware drop shadows)
  function updateScrollShadows() {
    var wrap = resultsContainer.closest('.search-modal__results-wrap');
    if (!wrap) return;
    var atTop = resultsContainer.scrollTop <= 0;
    var atBottom = resultsContainer.scrollTop + resultsContainer.clientHeight >= resultsContainer.scrollHeight;
    wrap.classList.toggle('has-scroll-top', !atTop);
    wrap.classList.toggle('has-scroll-bottom', !atBottom);
  }

  // Open modal
  function openModal() {
    lastFocusedElement = document.activeElement;
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    modal.classList.add('search-modal--open');

    // Focus input after transition starts
    setTimeout(function() {
      input.focus();
    }, 50);
  }

  // Close modal
  function closeModal() {
    modal.classList.remove('search-modal--open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';

    // Clear search
    input.value = '';
    resultsContainer.innerHTML = '';
    currentResults = [];
    selectedIndex = -1;
    updateScrollShadows();

    // Return focus
    if (lastFocusedElement) {
      lastFocusedElement.focus();
    }
  }

  // Render search results
  function renderResults(results) {
    currentResults = results;
    selectedIndex = -1;

    if (results.length === 0) {
      resultsContainer.innerHTML = '<div class="search-modal__no-results">No results found</div>';
      return;
    }

    const list = document.createElement('ul');
    list.className = 'search-results__list';
    list.setAttribute('role', 'listbox');

    results.forEach(function(item, index) {
      const li = document.createElement('li');
      li.setAttribute('role', 'option');
      li.setAttribute('aria-selected', 'false');
      li.setAttribute('data-index', index);

      const wrapper = document.createElement('div');
      wrapper.className = 'search-result';

      // Thumbnail for books
      if (item.thumbnail) {
        const thumb = document.createElement('img');
        thumb.src = item.thumbnail;
        thumb.alt = '';
        thumb.className = 'search-result__thumb';
        wrapper.appendChild(thumb);
      }

      const content = document.createElement('div');
      content.className = 'search-result__content';

      const title = document.createElement('span');
      title.className = 'search-result__title';
      title.textContent = item.title;
      content.appendChild(title);

      // Author for books, excerpt for posts/pages
      if (item.author) {
        const author = document.createElement('span');
        author.className = 'search-result__author';
        author.textContent = item.author;
        content.appendChild(author);
      } else if (item.excerpt) {
        const excerpt = document.createElement('span');
        excerpt.className = 'search-result__excerpt';
        excerpt.textContent = item.excerpt;
        content.appendChild(excerpt);
      }

      wrapper.appendChild(content);

      // Type badge
      const badge = document.createElement('span');
      badge.className = 'search-result__badge';
      badge.textContent = item.type_label;
      wrapper.appendChild(badge);

      li.appendChild(wrapper);

      // Click to navigate
      li.addEventListener('click', function() {
        window.location.href = item.url;
      });

      list.appendChild(li);
    });

    resultsContainer.innerHTML = '';
    resultsContainer.appendChild(list);
    setTimeout(updateScrollShadows, 0);
  }

  // Update selection highlight
  function updateSelection() {
    const items = resultsContainer.querySelectorAll('li[role="option"]');
    items.forEach(function(item, index) {
      if (index === selectedIndex) {
        item.setAttribute('aria-selected', 'true');
        item.scrollIntoView({ block: 'nearest' });
      } else {
        item.setAttribute('aria-selected', 'false');
      }
    });
  }

  // Perform search
  function performSearch(query) {
    if (query.length < 2) {
      resultsContainer.innerHTML = '';
      currentResults = [];
      updateScrollShadows();
      return;
    }

    modal.classList.add('search-modal--loading');

    fetch(hypatiaSearch.endpoint + '?q=' + encodeURIComponent(query))
      .then(function(response) {
        return response.json();
      })
      .then(function(results) {
        modal.classList.remove('search-modal--loading');
        renderResults(results);
      })
      .catch(function(error) {
        modal.classList.remove('search-modal--loading');
        resultsContainer.innerHTML = '<div class="search-modal__no-results">Search failed. Please try again.</div>';
        setTimeout(updateScrollShadows, 0);
      });
  }

  // Debounced search
  function debouncedSearch() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(function() {
      performSearch(input.value.trim());
    }, 200);
  }

  // Input event
  input.addEventListener('input', debouncedSearch);

  // Keyboard navigation
  input.addEventListener('keydown', function(e) {
    const items = resultsContainer.querySelectorAll('li[role="option"]');

    if (e.key === 'ArrowDown') {
      e.preventDefault();
      if (selectedIndex < items.length - 1) {
        selectedIndex++;
        updateSelection();
      }
    } else if (e.key === 'ArrowUp') {
      e.preventDefault();
      if (selectedIndex > 0) {
        selectedIndex--;
        updateSelection();
      }
    } else if (e.key === 'Enter') {
      e.preventDefault();
      if (selectedIndex >= 0 && currentResults[selectedIndex]) {
        window.location.href = currentResults[selectedIndex].url;
      }
    }
  });

  // Global keyboard shortcut: Cmd+K / Ctrl+K
  document.addEventListener('keydown', function(e) {
    const isMac = navigator.platform.toUpperCase().indexOf('MAC') >= 0;
    const modifier = isMac ? e.metaKey : e.ctrlKey;

    if (modifier && e.key === 'k') {
      e.preventDefault();
      const isOpen = modal.getAttribute('aria-hidden') === 'false';
      if (isOpen) {
        closeModal();
      } else {
        openModal();
      }
    }

    // ESC to close
    if (e.key === 'Escape' && modal.getAttribute('aria-hidden') === 'false') {
      e.preventDefault();
      closeModal();
    }
  });

  // Trigger button click
  trigger.addEventListener('click', function(e) {
    e.preventDefault();
    openModal();
  });

  // Backdrop click to close
  backdrop.addEventListener('click', function(e) {
    if (e.target === backdrop) {
      closeModal();
    }
  });

  // Close button click
  closeBtn.addEventListener('click', function(e) {
    e.preventDefault();
    closeModal();
  });

  // Scroll-aware shadows on the results area
  resultsContainer.addEventListener('scroll', updateScrollShadows);
  if (typeof ResizeObserver !== 'undefined') {
    var ro = new ResizeObserver(function() {
      updateScrollShadows();
    });
    ro.observe(resultsContainer);
  }

  // Focus trap
  modal.addEventListener('keydown', function(e) {
    if (e.key !== 'Tab') return;

    const focusableElements = modal.querySelectorAll(
      'input, button, [tabindex]:not([tabindex="-1"])'
    );
    const firstElement = focusableElements[0];
    const lastElement = focusableElements[focusableElements.length - 1];

    if (e.shiftKey) {
      if (document.activeElement === firstElement) {
        e.preventDefault();
        lastElement.focus();
      }
    } else {
      if (document.activeElement === lastElement) {
        e.preventDefault();
        firstElement.focus();
      }
    }
  });
})();
