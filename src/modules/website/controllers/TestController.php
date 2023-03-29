<?php
	declare(strict_types=1);

	namespace app\modules\website\controllers;

	use app\modules\website\Controller;
	use GuzzleHttp\Client;
	use Yii;

	class TestController extends Controller
	{
		public function chat($uid, $msg, $type = "user")
		{
			$cache = \Yii::$app->cache;
			$res   = $cache->get($uid);
			if (empty($res)) {
				$res[] = [
					'role'    => $type,
					"content" => $msg,
				];
				$cache->set($uid, $res);
			} else {
				array_push($res, [
					'role'    => $type,
					"content" => $msg,
				]);
				$cache->set($uid, $res);
			}
			return $res;
		}

		public function actionIndex()
		{
			// 检查Accept头
			if (Yii::$app->request->headers->get('Accept') !== 'text/event-stream') {
				Yii::$app->response->statusCode = 406;
				Yii::$app->response->data = "Not Acceptable";
				return;
			}
			$text = Yii::$app->request->get('text', '');

			// 使用Yii Response来创建一个SSE响应
			$response         = Yii::$app->response;
			$response->format = \yii\web\Response::FORMAT_RAW;
			$response->headers->add('Content-Type', 'text/event-stream; charset=utf-8');
			$response->headers->add('Cache-Control', 'no-cache');
			$response->headers->add('Connection', 'keep-alive');
			$response->headers->add('Access-Control-Allow-Origin', '*');

			// 调用GPT-3 API并逐字发送响应
			$data = $this->callGptApi($text);
			$this->sendSseResponse($data, $response);
		}


		private function goGptApi()
		{
			$uid      = "3213";
			$text     = '你觉得你会哪些技能';
			$messages = $this->chat($uid, $text);
			$proxy    = 'socks5://127.0.0.1:1081';
			$client   = new Client([
				'base_uri' => 'https://api.openai.com/v1/',
				'headers'  => [
					'Content-Type'  => 'application/json',
					'Authorization' => 'Bearer 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',
				],
				'proxy'    => $proxy,
			]);

			$response = $client->post('chat/completions', [
				'json' => [
					"model"             => "gpt-3.5-turbo",
					'temperature'       => 0.7,
					'max_tokens'        => 100,
					'n'                 => 1,
					'stop'              => ['\n'],
					"presence_penalty"  => 1,
					"frequency_penalty" => 1,
					'messages'          => $messages,
				],
			]);
			$data     = json_decode($response->getBody()->getContents(),true);
			$text     = $data['choices'][0]['message']['content'];
			$this->chat($uid, $text, "system");
			return $data;
		}

		private function callGptApi($text)
		{
			$data = $this->goGptApi();
			// 返回API的响应
			return $data['choices'][0]['message']['content'];
		}

		private function sendSseResponse($data, $response)
		{
			var_dump($data);die;
			$response->headers->add('Content-Type', 'text/event-stream; charset=utf-8');
			// 逐字发送响应给客户端
			foreach (mb_str_split($data) as $char) {
				$response->content = "data: {$char}\n\n";
				$response->send();
			}
		}
	}