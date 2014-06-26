<?php
namespace SimpleIT\ClaireExerciseBundle\Feature\CreatedExercise;

use OC\Tester\ApiFeatureTest;
use SimpleIT\ApiBundle\Model\ApiResponse;
use SimpleIT\Utils\FormatUtils;

/**
 * Test Attempt By Test Attempt
 *
 * @author Baptiste Cable <baptiste.cable@liris.cnrs.fr>
 */
class AttemptByTestAttemptTest extends ApiFeatureTest
{
    const BAD_REQUEST_CODE = 400;

    const BAD_REQUEST = "Bad Request";

    const ID_TEST_1 = 1;

    const ID_TEST_2 = 2;

    const ID_TEST_NOT_EXISTING = 250;

    const TEST_RESOURCE_LIST_1 = '[{"id":1,"exercise":1,"test_attempt":1,"user":1000001,"position":0},{"id":2,"exercise":2,"test_attempt":1,"user":1000001,"position":1},{"id":3,"exercise":3,"test_attempt":1,"user":1000002,"position":2}]';

    const TEST_RESOURCE_LIST_2 = '[{"id":4,"exercise":4,"test_attempt":2,"user":1000002,"position":0},{"id":5,"exercise":2,"test_attempt":2,"user":1000002,"position":1}]';

    /**
     * @var string
     */
    protected $path = '/test-attempts/{testAttemptId}/attempts/';

    /**
     * Get list provider
     *
     * @return array
     */
    public static function getListProvider()
    {
        return array(
            array(
                self::ID_TEST_1,
                ApiResponse::STATUS_CODE_OK,
                self::TEST_RESOURCE_LIST_1,
            ),
            array(
                self::ID_TEST_2,
                ApiResponse::STATUS_CODE_OK,
                self::TEST_RESOURCE_LIST_2,
            ),
            array(
                self::ID_TEST_NOT_EXISTING,
                ApiResponse::STATUS_CODE_CONTENT_NOT_FOUND,
                'Not Found',
            ),
        );
    }

    /**
     * Test GET on collection
     *
     * @param int     $inputIdentifier    Exercise model id
     * @param integer $expectedStatusCode Expected status code
     * @param string  $expectedContent    Expected content
     * @param array   $parameters
     * @param array   $headers
     *
     * @dataProvider getListProvider
     */
    public function testList(
        $inputIdentifier,
        $expectedStatusCode,
        $expectedContent,
        array $parameters = array(),
        array $headers = array()
    )
    {
        $response = $this->getAll(
            array('testAttemptId' => $inputIdentifier),
            $parameters,
            $headers,
            array(),
            FormatUtils::JSON
        );

        $this->assertEquals($expectedStatusCode, $response->getStatusCode());
        $this->assertEquals($expectedContent, $response->getContent());
    }

    /**
     * @inheritdoc
     * @return \PHPUnit_Extensions_Database_DataSet_IDataSet|\PHPUnit_Extensions_Database_DataSet_XmlDataSet
     */
    protected function getDataSet()
    {
        return new \PHPUnit_Extensions_Database_DataSet_CompositeDataSet(
            array(
                $this->createXMLDataSet(__DIR__ . '/../../Dataset/authentification_dataset.xml'),
                $this->createXMLDataSet(__DIR__ . '/../../Dataset/resource_dataset.xml'),
                $this->createXMLDataSet(__DIR__ . '/../../Dataset/exercise_model_dataset.xml'),
                $this->createXMLDataSet(__DIR__ . '/../../Dataset/stored_exercise_dataset.xml'),
                $this->createXMLDataSet(__DIR__ . '/../../Dataset/test_model_dataset.xml'),
                $this->createXMLDataSet(__DIR__ . '/../../Dataset/test_dataset.xml'),
                $this->createXMLDataSet(__DIR__ . '/../../Dataset/attempt_dataset.xml'),
                $this->createXMLDataSet(__DIR__ . '/../../Dataset/item_dataset.xml'),
                $this->createXMLDataSet(__DIR__ . '/../../Dataset/answer_dataset.xml'),
                $this->createXMLDataSet(__DIR__ . '/../../Dataset/knowledge_dataset.xml'),
            ));
    }
}
