<?php

class JsonPlaceholderAPI
{
    private $base_url = "https://jsonplaceholder.typicode.com";
    
    public function getUsers()
    {
        $url = $this->base_url . "/users";
        $response = $this->sendRequest($url);
        return json_decode($response, true);
    }
    
    public function getUserPosts($userId)
    {
        $url = $this->base_url . "/posts?userId=" . $userId;
        $response = $this->sendRequest($url);
        return json_decode($response, true);
    }
    
    public function getUserTodos($userId)
    {
        $url = $this->base_url . "/todos?userId=" . $userId;
        $response = $this->sendRequest($url);
        return json_decode($response, true);
    }
    
    public function addPost($userId, $title, $body)
    {
        $url = $this->base_url . "/posts";
        $postdata = array(
            "userId" => $userId,
            "title" => $title,
            "body" => $body
        );
        $response = $this->sendRequest($url, "POST", $postdata);
        return json_decode($response, true);
    }
    
    public function editPost($postId, $title, $body)
    {
        $url = $this->base_url . "/posts/" . $postId;
        $postdata = array(
            "title" => $title,
            "body" => $body
        );
        $response = $this->sendRequest($url, "PUT", $postdata);
        return json_decode($response, true);
    }
    
    public function deletePost($postId)
    {
        $url = $this->base_url . "/posts/" . $postId;
        $response = $this->sendRequest($url, "DELETE");
        return json_decode($response, true);
    }
    
    private function sendRequest($url, $method = "GET", $data = array())
    {
        $ch = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($ch, CURLOPT_POST, 1);
                if (!empty($data)) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case "PUT":
            case "DELETE":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
                if (!empty($data)) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                }
                break;
            default:
                break;
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}

// Примеры вызовов для проверки:

$jsonAPI = new JsonPlaceholderAPI();

// Получить пользователей
$users = $jsonAPI->getUsers();
print_r($users);

// Получить посты пользователя
$userPosts = $jsonAPI->getUserPosts(1);
print_r($userPosts);

// Получить задания пользователя
$userTodos = $jsonAPI->getUserTodos(1);
print_r($userTodos);

// Добавить новую запись
$newPost = $jsonAPI->addPost(1, "Новый пост", "Это новый пост.");
print_r($newPost);

// Редактировать пост
$editedPost = $jsonAPI->editPost(1, "Отредактированный пост", "Этот пост был отредактирован.");
print_r($editedPost);

// Удалить пост
$deletedPost = $jsonAPI->deletePost(1);
print_r($deletedPost);

?>