<?php $this->layout("layout", ["title" => "Zoutstrooiplanner"]) ?>

<main class="container">
    <section class="hero">
        <h1>Zoutstrooiplanner</h1>
        <p>Vul de temperatuur in en bekijk direct hoe vaak er gestrooid moet worden.</p>
    </section>

    <section class="card">
        <form method="get" action="/">
            <label for="temperature">Temperatuur in graden Celsius</label>
            <div class="row">
                <input
                    type="number"
                    id="temperature"
                    name="temperature"
                    step="0.1"
                    required
                    value="<?= $temperature !== null ? $this->e((string) $temperature) : "" ?>"
                >
                <button type="submit">Bereken planning</button>
            </div>
        </form>
    </section>

    <?php if ($frequency !== null): ?>
        <section class="card results">
            <h2>Resultaat</h2>
            <p>
                Bij <strong><?= $this->e((string) $temperature) ?> graden C</strong>
                moet elke route <strong><?= $frequency ?>x</strong> gestrooid worden.
            </p>
            <table>
                <thead>
                    <tr>
                        <th>Route</th>
                        <th>Tijd per beurt (min)</th>
                        <th>Totale tijd vandaag (min)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= $this->e($item["name"]) ?></td>
                            <td><?= $item["baseMinutes"] ?></td>
                            <td><?= $item["totalMinutes"] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p><strong>Totale strooitijd:</strong> <?= $totalMinutes ?> minuten</p>
            <p><strong>Benodigde strooiwagens:</strong> <?= $trucksNeeded ?> (uitgaande van 480 minuten per wagen)</p>
        </section>
    <?php endif; ?>
</main>
