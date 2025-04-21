document.querySelectorAll('[href], [src]').forEach(el => {
    ['href', 'src'].forEach(attr => {
      if (el[attr] && el[attr].includes(OLD_URL)) {
        el[attr] = el[attr].replaceAll(OLD_URL, NEW_URL);
      }
    });
  });