<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quittance de Loyer - {{ $paiement->mois }}/{{ $paiement->annee }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #2c5282;
        }
        .header .subtitle {
            font-size: 16px;
            color: #666;
            margin: 5px 0;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2c5282;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
        }
        .info-item {
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: bold;
            color: #555;
            margin-bottom: 2px;
        }
        .info-value {
            color: #333;
        }
        .amount-box {
            border: 2px solid #2c5282;
            padding: 15px;
            text-align: center;
            margin: 20px 0;
            background-color: #f7fafc;
        }
        .amount {
            font-size: 24px;
            font-weight: bold;
            color: #2c5282;
        }
        .signature-area {
            margin-top: 50px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 200px;
            margin-top: 40px;
        }
        .footer {
            margin-top: 50px;
            font-size: 10px;
            color: #666;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(0,0,0,0.1);
            z-index: -1;
        }
        .montant-en-lettres {
            font-style: italic;
            margin-top: 10px;
            color: #555;
        }
    </style>
</head>
<body>
    <!-- Filigrane -->
    <div class="watermark">QUITTANCE</div>

    <!-- En-tête -->
    <div class="header">
        <h1>QUITTANCE DE LOYER</h1>
        <div class="subtitle">Reçu de paiement de loyer</div>
        <div class="subtitle">Période : {{ \Carbon\Carbon::createFromDate($paiement->annee, $paiement->mois, 1)->locale('fr')->isoFormat('MMMM YYYY') }}</div>
    </div>

    <!-- Informations propriétaire et locataire -->
    <div class="section">
        <div class="grid-2">
            <div>
                <div class="section-title">BAILLEUR</div>
                <div class="info-item">
                    <div class="info-label">Nom/Raison sociale</div>
                    <div class="info-value">VOTRE NOM / VOTRE SOCIÉTÉ</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Adresse</div>
                    <div class="info-value">VOTRE ADRESSE</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Téléphone</div>
                    <div class="info-value">VOTRE TÉLÉPHONE</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">VOTRE EMAIL</div>
                </div>
            </div>

            <div>
                <div class="section-title">LOCATAIRE</div>
                <div class="info-item">
                    <div class="info-label">Nom</div>
                    <div class="info-value">{{ $paiement->contrat->locataire->prenom }} {{ $paiement->contrat->locataire->nom }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Adresse</div>
                    <div class="info-value">{{ $paiement->contrat->appartement->immeuble->adresse }}, {{ $paiement->contrat->appartement->immeuble->code_postal }} {{ $paiement->contrat->appartement->immeuble->ville }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Appartement</div>
                    <div class="info-value">{{ $paiement->contrat->appartement->numero }} - {{ $paiement->contrat->appartement->surface }} m²</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Détails du paiement -->
    <div class="section">
        <div class="section-title">DÉTAILS DU PAIEMENT</div>
        <div class="grid-3">
            <div class="info-item">
                <div class="info-label">Période de loyer</div>
                <div class="info-value">
                    Du 1er au {{ date('t', mktime(0, 0, 0, $paiement->mois, 1, $paiement->annee)) }}
                    {{ \Carbon\Carbon::createFromDate($paiement->annee, $paiement->mois, 1)->locale('fr')->isoFormat('MMMM YYYY') }}
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">Date de paiement</div>
                <div class="info-value">{{ $paiement->date_paiement->format('d/m/Y') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Mode de paiement</div>
                <div class="info-value">{{ $paiement->mode_paiement }}</div>
            </div>
        </div>
    </div>

    <!-- Montant -->
    <div class="amount-box">
        <div style="font-size: 16px; margin-bottom: 10px;">MONTANT REÇU</div>
        <div class="amount">{{ number_format($paiement->montant, 2, ',', ' ') }} XOF</div>
        <div class="montant-en-lettres">
            {{ $paiement->getMontantEnLettres() }}
        </div>
    </div>

    <!-- Détails du contrat -->
    <div class="section">
        <div class="section-title">INFORMATIONS DU CONTRAT</div>
        <div class="grid-3">
            <div class="info-item">
                <div class="info-label">Référence contrat</div>
                <div class="info-value">#{{ $paiement->contrat->id }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Loyer mensuel</div>
                <div class="info-value">{{ number_format($paiement->contrat->loyer_mensuel, 2, ',', ' ') }} XOF</div>
            </div>
            <div class="info-item">
                <div class="info-label">Dépôt de garantie</div>
                <div class="info-value">{{ number_format($paiement->contrat->depot_garantie, 2, ',', ' ') }} XOF</div>
            </div>
        </div>
        <div class="grid-2" style="margin-top: 10px;">
            <div class="info-item">
                <div class="info-label">Date début contrat</div>
                <div class="info-value">{{ $paiement->contrat->date_debut->format('d/m/Y') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Date fin contrat</div>
                <div class="info-value">{{ $paiement->contrat->date_fin->format('d/m/Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Notes -->
    @if($paiement->notes)
    <div class="section">
        <div class="section-title">OBSERVATIONS</div>
        <div class="info-value">{{ $paiement->notes }}</div>
    </div>
    @endif

    <!-- Signature -->
    <div class="signature-area">
        <div style="text-align: right;">
            <div>Fait à ____________________, le {{ date('d/m/Y') }}</div>
            <div style="margin-top: 40px;">
                <div class="signature-line"></div>
                <div style="text-align: center; margin-top: 5px;">Signature du bailleur</div>
            </div>
        </div>
    </div>

    <!-- Pied de page -->
    <div class="footer">
        <div>Quittance générée automatiquement le {{ date('d/m/Y à H:i') }}</div>
        <div>Référence paiement : #{{ $paiement->id }} | Contrat : #{{ $paiement->contrat->id }}</div>
        <div>Ce document fait foi de paiement et doit être conservé par le locataire</div>
    </div>
</body>
</html>
