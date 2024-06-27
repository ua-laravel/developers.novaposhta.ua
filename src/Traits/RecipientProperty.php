<?php

namespace ProfiWM\NovaPoshta\Traits;

trait RecipientProperty
{
    protected $RecipientType;

    /**
     * Устанавливаем значение получателя.
     *
     * @param  array  $Recipient  Массив данных получателя
     * @return $this
     */
    public function setRecipient(array $Recipient): self
    {
        if (isset($Recipient['RecipientsPhone'])) {
            $this->methodProperties['RecipientsPhone'] = $Recipient['RecipientsPhone'];
        }

        //указываем идентификаторами проверяем и вставляем
        if (isset($Recipient['Recipient']) &&
            isset($Recipient['ContactRecipient']) &&
            isset($Recipient['CityRecipient']) &&
            isset($Recipient['RecipientAddress'])
        ) {
            $this->methodProperties['Recipient'] = $Recipient['Recipient'];
            $this->methodProperties['ContactRecipient'] = $Recipient['ContactRecipient'];
            $this->methodProperties['CityRecipient'] = $Recipient['CityRecipient'];
            $this->methodProperties['RecipientAddress'] = $Recipient['RecipientAddress'];

            return $this;
        }

        //указываем строками проверяем и вставляем
        if (isset($Recipient['RecipientName']) &&     //имя получателя
            isset($Recipient['RecipientCityName']) && //город
            isset($Recipient['RecipientAddressName']) //отделение или улица
        ) {
            //создаем новый адрес
            $this->methodProperties['NewAddress'] = 1;

            $this->methodProperties['RecipientName'] = $Recipient['RecipientName'];
            $this->methodProperties['RecipientCityName'] = $Recipient['RecipientCityName'];
            $this->methodProperties['RecipientAddressName'] = $Recipient['RecipientAddressName'];

            $this->methodProperties['RecipientArea'] = $Recipient['RecipientArea'] ?? '';
            $this->methodProperties['RecipientAreaRegions'] = $Recipient['RecipientAreaRegions'] ?? '';
            $this->methodProperties['RecipientHouse'] = $Recipient['RecipientHouse'] ?? '';
            $this->methodProperties['RecipientFlat'] = $Recipient['RecipientFlat'] ?? '';
        }

        return $this;
    }

    /**
     * Устанавливаем тип получателя.
     *
     * @param  string  $RecipientType  Тип получателя ('PrivatePerson', 'Organization')
     * @return $this
     */
    public function setRecipientType(string $RecipientType): self
    {
        $this->RecipientType = $RecipientType;

        return $this;
    }

    /**
     * Тип получателя. По-умолчанию значение конфига.
     *
     * @return void
     */
    public function getRecipientType(): void
    {
        $this->methodProperties['RecipientType'] = $this->RecipientType ?: config('novaposhta.recipient_type');
    }
}
