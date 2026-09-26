<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle ?? 'Escola Cristã Nova Esperança - Kifangondo, Sequele · Ícolo e Bengo') ?></title>
  
  <!-- Google Fonts: Plus Jakarta Sans & Inter (Stitch Design System) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
  
  <!-- Material Symbols Outlined -->
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
  
  <!-- Tailwind CSS CDN com Configuração Fiel ao Stitch -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "surface-container-low": "#f8fafc",
            "surface-container-lowest": "#ffffff",
            "surface-container": "#f0f9fd",
            "surface-container-high": "#e0f4fc",
            "surface": "#ffffff",
            "primary": "#009ada",
            "primary-dark": "#006fa1",
            "primary-container": "#f0f9fd",
            "on-primary": "#ffffff",
            "on-primary-container": "#006fa1",
            "primary-fixed": "#d0f2ff",
            "on-primary-fixed": "#00486b",
            "brand-green": "#006338",
            "brand-green-dark": "#004728",
            "secondary": "#ac3400",
            "secondary-container": "#fd6b36",
            "secondary-fixed": "#ffdbd0",
            "on-secondary-fixed": "#390c00",
            "tertiary": "#623c00",
            "tertiary-fixed": "#ffddb8",
            "on-tertiary-fixed-variant": "#653e00",
            "hope-amber-dark": "#d97706",
            "nutrition-green": "#01a85a",
            "nutrition-green-dark": "#008748",
            "outline": "#747686",
            "outline-variant": "#c4c5d7",
            "on-surface": "#131b2e",
            "on-surface-variant": "#434655",
            "on-background": "#131b2e"
          },
          fontFamily: {
            "display-lg": ["Plus Jakarta Sans", "sans-serif"],
            "headline-lg": ["Plus Jakarta Sans", "sans-serif"],
            "headline-md": ["Plus Jakarta Sans", "sans-serif"],
            "headline-sm": ["Plus Jakarta Sans", "sans-serif"],
            "metric-stat": ["Plus Jakarta Sans", "sans-serif"],
            "body-lg": ["Inter", "sans-serif"],
            "body-md": ["Inter", "sans-serif"],
            "body-sm": ["Inter", "sans-serif"],
            "label-md": ["Inter", "sans-serif"],
            "label-sm": ["Inter", "sans-serif"]
          }
        }
      }
    }
  </script>
  <style>
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24;
      display: inline-block;
      vertical-align: middle;
      line-height: 1;
    }
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
</head>
<body class="bg-surface-container-low text-on-surface font-body-md antialiased min-h-screen pb-24 md:pb-0 selection:bg-primary-fixed selection:text-on-primary-fixed">

  <!-- TOP APP BAR DO STITCH -->
  <?= \NovaEsperanca\Core\View::partial('top-app-bar', ['currentRoute' => $currentRoute ?? '/']) ?>

  <!-- VIEWPORT CONTAINER (Mobile-First max-w-screen-md · Expansão Progressiva até max-w-7xl) -->
  <main class="w-full max-w-screen-md md:max-w-5xl lg:max-w-7xl mx-auto px-4 md:px-6 pt-4 space-y-6">
    <?= $content ?>
  </main>

  <!-- RODAPÉ INSTITUCIONAL (Visível apenas em >= 768px) -->
  <?= \NovaEsperanca\Core\View::partial('desktop-footer', ['currentRoute' => $currentRoute ?? '/']) ?>

  <!-- MODAL DE APADRINHAMENTO EM 2 ETAPAS -->
  <?= \NovaEsperanca\Core\View::partial('modal-apadrinhamento') ?>

  <!-- BOTTOM NAVIGATION BAR DO STITCH -->
  <?= \NovaEsperanca\Core\View::partial('bottom-nav', ['currentRoute' => $currentRoute ?? '/']) ?>

  <!-- SCRIPT CLIENT-SIDE LEVE -->
  <script src="/js/app.js"></script>
</body>
</html>
