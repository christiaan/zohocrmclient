<?php
namespace Christiaan\ZohoCRMClient\Request;

use Christiaan\ZohoCRMClient\Response\MutationResult;

/**
 * ConvertLead API Call
 *
 * @see https://www.zoho.com/crm/help/api/convertlead.html
 */
class ConvertLead extends AbstractRequest
{
    /**
     * @var array
     */
    private $records;

    /**
     * Configure the request.
     *
     * @return void
     */
    protected function configureRequest()
    {
        $this->request
            ->setMethod('convertLead');
    }

    /**
     * @param string $id The Zoho ID of the record to convert.
     * @return ConvertLead
     */
    public function id($id)
    {
        $this->request->setParam('leadId', $id);

        return $this;
    }

    /**
     * @param array $records Array containing records. First applies to contact and account, second to potential.
     *                       The second record should be omitted if the xmlData contains createPotential false.
     * @return ConvertLead
     */
    public function setRecords(array $records)
    {
        $this->records = $records;
        return $this;
    }

    /**
     * @return MutationResult[]
     */
    public function request()
    {
        return $this->request
            ->setParam('xmlData', $this->records)
            ->request();
    }
}
