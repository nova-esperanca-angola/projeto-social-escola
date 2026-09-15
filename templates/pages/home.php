<!-- PÁGINA HOME: FIEL AO MOCKUP DO STITCH -->
<?= \NovaEsperanca\Core\View::partial('hero') ?>
<?= \NovaEsperanca\Core\View::partial('bento-impacto', $metricas ?? []) ?>
<?= \NovaEsperanca\Core\View::partial('termometro-obras', $transparencia['fundo_obras_salas'] ?? []) ?>
<?= \NovaEsperanca\Core\View::partial('planos-apadrinhamento') ?>
<?= \NovaEsperanca\Core\View::partial('widget-diagnostico', $diagnostico ?? []) ?>
<?= \NovaEsperanca\Core\View::partial('canais-apoio') ?>
