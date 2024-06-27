<?php

namespace ProfiWM\NovaPoshta\Traits;

trait InternetDocumentProperty
{
    protected $Ref;
    protected $PayerType;
    protected $ServiceType;
    protected $PaymentMethod;
    protected $CargoType;
    protected $SeatsAmount;
    protected $Cost;
    protected $Weight;
    protected $BackwardDeliveryData;
    protected $AfterpaymentOnGoodsCost;
    protected $Note;
    protected $AdditionalInformation;

    /**
     * Устанавливаем значение Ref.
     *
     * @param  string  $Ref  Указываем Ref
     * @return $this
     */
    public function setRef(string $Ref): self
    {
        $this->Ref = $Ref;

        return $this;
    }

    public function getRef(): void
    {
        $this->methodProperties['Ref'] = $this->Ref;
    }

    /**
     * Устанавливаем значение плательщика. По умолчанию значение конфига.
     *
     * @param  string  $PayerType  Значение плательщика ('Sender', 'Recipient', 'ThirdPerson')
     * @return $this
     */
    public function setPayerType(string $PayerType): self
    {
        $this->PayerType = $PayerType;

        return $this;
    }

    /**
     * @return void
     */
    public function getPayerType(): void
    {
        $this->methodProperties['PayerType'] = $this->PayerType ?: config('novaposhta.payer_type');
    }

    /**
     * Устанавливаем тип доставки. По умолчанию значение конфига.
     *
     * @param  string  $ServiceType  Тип доставки ('DoorsDoors', 'DoorsWarehouse', 'WarehouseWarehouse', 'WarehouseDoors')
     * @return $this
     */
    public function setServiceType(string $ServiceType): self
    {
        $this->ServiceType = $ServiceType;

        return $this;
    }

    /**
     * @return void
     */
    public function getServiceType(): void
    {
        $this->methodProperties['ServiceType'] = $this->ServiceType ?: config('novaposhta.service_type');
    }

    /**
     * Устанавливаем форму оплаты. По умолчанию значение конфига.
     *
     * @param  string  $PaymentMethod  Форма оплаты ('Cash', 'NonCash')
     * @return $this
     */
    public function setPaymentMethod(string $PaymentMethod): self
    {
        $this->PaymentMethod = $PaymentMethod;

        return $this;
    }

    /**
     * Разные значения по умолчанию для разных моделей.
     *
     * @return void
     */
    public function getPaymentMethod(): void
    {
        if ($this->model == 'AdditionalService') {
            $this->methodProperties['PaymentMethod'] = $this->PaymentMethod ?: config('novaposhta.return_cash_method');
        } elseif ($this->model == 'orderTermExtension') {
            $this->methodProperties['PaymentMethod'] = $this->PaymentMethod ?: config('novaposhta.term_payment_method');
        } else {
            $this->methodProperties['PaymentMethod'] = $this->PaymentMethod ?: config('novaposhta.payment_method');
        }
    }

    /**
     * Устанавливаем тип груза. По умолчанию значение конфига.
     *
     * @param  string  $CargoType  Tип груза ('Cargo', 'Documents', 'TiresWheels', 'Pallet', 'Parcel')
     * @return $this
     */
    public function setCargoType(string $CargoType): self
    {
        $this->CargoType = $CargoType;

        return $this;
    }

    /**
     * @return void
     */
    public function getCargoType(): void
    {
        $this->methodProperties['CargoType'] = $this->CargoType ?: config('novaposhta.cargo_type');
    }

    /**
     * Устанавливаем описание груза. По умолчанию из конфига.
     *
     * @param  string|null  $description  Описание груза
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->methodProperties['Description'] = $description ?: config('novaposhta.description');

        return $this;
    }

    /**
     * Кол-во мест груза по умолчанию.
     *
     * @param  string  $SeatsAmount  Количество мест отправки
     * @return $this
     */
    public function setSeatsAmount(string $SeatsAmount): self
    {
        $this->SeatsAmount = $SeatsAmount;

        return $this;
    }

    /**
     * @return void
     */
    public function getSeatsAmount(): void
    {
        $this->methodProperties['SeatsAmount'] = $this->SeatsAmount ?: config('novaposhta.seats_amount');
    }

    /**
     * Устанавливаем стоимость груза. По умолчанию значение конфига.
     *
     * @param  string  $cost  Оценочная стоимость
     * @return $this
     */
    public function setCost(string $cost): self
    {
        $this->Cost = $cost;

        return $this;
    }

    /**
     * @return void
     */
    public function getCost(): void
    {
        $this->methodProperties['Cost'] = $this->Cost ?: config('novaposhta.cost');
    }

    /**
     * Описание к адресу для курьера или отделения.
     * Применяется в основном, если нет текущей улицы при адресной доставке.
     *
     * @param  string  $note  Пометка
     * @return $this
     */
    public function setNote(string $note): self
    {
        $this->Note = $note;

        return $this;
    }

    /**
     * @return void
     */
    public function getNote(): void
    {
        if ($this->Note) {
            $this->methodProperties['Note'] = $this->Note;
        }
    }

    /**
     * Описание к ТТН для отображения в кабинете.
     *
     * @param  string  $AdditionalInformation  Дополнительная информация к грузу
     * @return $this
     */
    public function setAdditionalInformation(string $AdditionalInformation): self
    {
        $this->AdditionalInformation = $AdditionalInformation;

        return $this;
    }

    /**
     * @return void
     */
    public function getAdditionalInformation(): void
    {
        if ($this->AdditionalInformation) {
            $this->methodProperties['AdditionalInformation'] = $this->AdditionalInformation;
        }
    }

    /**
     * Услуга обратной доставки. По умолчанию значения конфига.
     *
     * @param  string|int  $RedeliveryString  Обратная доставка денег (наложный платеж)
     * @param  string|null  $PayerType  Значение плательщика ('Sender', 'Recipient', 'ThirdPerson')
     * @param  string|null  $CargoType  Tип груза ('Cargo', 'Documents', 'TiresWheels', 'Pallet', 'Parcel')
     * @return $this
     */
    public function setBackwardDeliveryData($RedeliveryString, ?string $PayerType = null, ?string $CargoType = null): self
    {
        if (! $PayerType) {
            $PayerType = config('novaposhta.back_delivery_payer_type');
        }
        if (! $CargoType) {
            $CargoType = config('novaposhta.back_delivery_cargo_type');
        }
        $this->BackwardDeliveryData = [
            'PayerType' => $PayerType,
            'CargoType' => $CargoType,
            'RedeliveryString' => $RedeliveryString,
        ];

        return $this;
    }

    /**
     * Услуга Контроль оплаты.
     *
     * @param  string|int  $AfterpaymentOnGoodsCost  Контроль оплаты (Наложка на карту предпринимателя)
     * @return $this
     */
    public function setAfterpaymentOnGoodsCost($AfterpaymentOnGoodsCost): self
    {
        $this->AfterpaymentOnGoodsCost = $AfterpaymentOnGoodsCost;

        return $this;
    }

    /**
     * @return void
     */
    public function getBackwardDeliveryData(): void
    {
        if ($this->AfterpaymentOnGoodsCost) {
            $this->methodProperties['AfterpaymentOnGoodsCost'] = $this->AfterpaymentOnGoodsCost;
        } elseif ($this->BackwardDeliveryData) {
            $this->methodProperties['BackwardDeliveryData'][] = $this->BackwardDeliveryData;
        }
    }
}
